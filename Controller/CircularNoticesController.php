<?php
/**
 * CircularNotices Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CircularNoticesAppController', 'CircularNotices.Controller');

/**
 * CircularNotices Controller
 *
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @package NetCommons\CircularNotices\Controller
 */
class CircularNoticesController extends CircularNoticesAppController {

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'Frames.Frame',
		'Blocks.Block',
		'Auth.Auth',
		'CircularNotices.CircularNoticeFrameSetting',
		'CircularNotices.CircularNoticeSetting',
		'CircularNotices.CircularNoticeContent',
		'CircularNotices.CircularNoticeChoice',
		'CircularNotices.CircularNoticeTargetUser',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'Workflow.Workflow',
		'NetCommons.Permission' => array(
			//アクセスの権限
			'allow' => array(
				'edit,delete' => 'content_creatable',
			),
		),
		'Paginator',
	);

/**
 * beforeFilters
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
	}

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Token',
		'Workflow.Workflow',
	);

/**
 * index action
 *
 * @return void
 */
	public function index() {
		$userId = Current::read('User.id');
		if (! $userId) {
			$this->autoRender = false;
			return;
		}

		$this->initCircularNotice();

		// Paginator経由で一覧を取得
		$this->Paginator->settings = $this->CircularNoticeContent->getCircularNoticeContentsForPaginate(
			$this->viewVars['circularNoticeSetting']['CircularNoticeSetting']['key'],
			$userId,
			$this->params['named'],
			$this->viewVars['circularNoticeFrameSetting']['CircularNoticeFrameSetting']['display_number']
		);
		$contents = $this->Paginator->paginate('CircularNoticeContent');

		// 各回覧データの閲覧／回答件数を取得
		foreach ($contents as $i => $content) {
			// 閲覧件数／回答件数を取得してセット
			// FIXME: 表示件数が多い場合、クエリ発行回数がかなり増える
			$counts = $this->CircularNoticeTargetUser->getCircularNoticeTargetUserCount((int)$content['CircularNoticeContent']['id']);
			$contents[$i]['targetCount'] = $counts['targetCount'];
			$contents[$i]['readCount'] = $counts['readCount'];
			$contents[$i]['replyCount'] = $counts['replyCount'];
		}

		// 画面表示のためのデータを設定
		$contents = $this->camelizeKeyRecursive($contents);
		$this->set('circularNoticeContents', $contents);
	}

/**
 * view action
 *
 * @param int $frameId frames.id
 * @param int $contentId circular_notice_content.id
 * @return void
 */
	public function view($frameId = null, $contentId = null, $key = null) {
//		$userId = (int)$this->Auth->user('id');
		$userId = Current::read('User.id');
		$this->initCircularNotice();

		$circularNoticeContentKey = null;
		if (isset($this->params['pass'][1])) {
			$circularNoticeContentKey = $this->params['pass'][1];
		}

		// 回覧を取得
		$content = $this->CircularNoticeContent->getCircularNoticeContent($circularNoticeContentKey, $userId);
		if (! $content) {
			$this->throwBadRequest();
			return false;
		}
		$contentId = $content['CircularNoticeContent']['id'];
		$myTargetUser = array();

		// ログイン者が回覧先に含まれる
//		if ($content['MyCircularNoticeTargetUser']) {
		if (!empty($content['MyCircularNoticeTargetUser']['user_id'])) {

			// 既読に更新
			$this->CircularNoticeTargetUser->saveRead($contentId, $userId);

			// ログイン者の回答を取得して整形
			$myTargetUser = array('CircularNoticeTargetUser' => $content['MyCircularNoticeTargetUser']);
			$myTargetUser['CircularNoticeTargetUser']['origin_reply_text_value'] = $myTargetUser['CircularNoticeTargetUser']['reply_text_value'];
			$myTargetUser['CircularNoticeTargetUser']['origin_reply_selection_value'] = $myTargetUser['CircularNoticeTargetUser']['reply_selection_value'];
		}

		// 回覧の閲覧件数／回答件数を取得
		$counts = $this->CircularNoticeTargetUser->getCircularNoticeTargetUserCount($contentId);

		// Paginator経由で回答先一覧を取得
		$this->Paginator->settings = $this->CircularNoticeTargetUser->getCircularNoticeTargetUsersForPaginator($contentId, $this->params['named'], $userId);
		$targetUsers = $this->Paginator->paginate('CircularNoticeTargetUser');

		// 回答を集計
		$answersSummary = $this->__getAnswerSummary($contentId);

		// 回答の登録／更新
		if ($this->request->is(array('post', 'put'))) {

			$replyTextValue = '';
			$replySelectionValue = '';
			if ($content['CircularNoticeContent']['reply_type'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT) {
				$replyTextValue = $this->data['CircularNoticeTargetUser']['reply_text_value'];
			} elseif ($content['CircularNoticeContent']['reply_type'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION) {
				$replySelectionValue = $this->data['CircularNoticeTargetUser']['reply_selection_value'];
			} elseif ($content['CircularNoticeContent']['reply_type'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION) {
				if ($this->data['CircularNoticeTargetUser']['reply_selection_value']) {
					$replySelectionValue = implode(CircularNoticeComponent::SELECTION_VALUES_DELIMITER, $this->data['CircularNoticeTargetUser']['reply_selection_value']);
				}
			}

			$data = Hash::merge(
				$this->data,
				['CircularNoticeTargetUser' => ['reply_flag' => true, 'reply_datetime' => date('Y-m-d H:i:s'), 'reply_text_value' => $replyTextValue, 'reply_selection_value' => $replySelectionValue]]
			);

			if ($this->CircularNoticeTargetUser->saveCircularNoticeTargetUser($data)) {
				$url = NetCommonsUrl::actionUrl(array(
					'controller' => $this->params['controller'],
					'action' => 'view',
					'block_id' => Current::read('Block.id'),
					'frame_id' => Current::read('Frame.id'),
					'key' => $this->request->data['CircularNoticeContent']['key']
				));
				$this->redirect($url);
				return;
			}
			$this->NetCommons->handleValidationError($this->CircularNoticeTargetUser->validationErrors);

			$myTargetUser['CircularNoticeTargetUser']['reply_text_value'] = $replyTextValue;
			$myTargetUser['CircularNoticeTargetUser']['reply_selection_value'] = $replySelectionValue;
		}

		$results = Hash::merge(
			$content, $counts,
			['MyAnswer' => $myTargetUser, 'CircularNoticeTargetUsers' => $targetUsers, 'AnswersSummary' => $answersSummary]
		);
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
	}

/**
 * add action
 *
 * @param int $frameId frames.id
 * @return void
 */
	public function add($frameId = null) {
//$this->log($this->request->data);
		$this->view = 'edit';
		$frameId = Current::read('Frame.id');
		$blockId = Current::read('Block.id');
		$this->initCircularNotice();

		$content = $this->CircularNoticeContent->create(array(
			'is_room_targeted_flag' => true,
			'target_groups' => ''
		));
		$content['CircularNoticeChoice'] = array();

		$data = array();
		if ($this->request->is('post')) {

			if (! $status = $this->Workflow->parseStatus()) {
				$this->throwBadRequest();
				return;
			}

			$data = $this->__parseRequestForSave();
			$data['CircularNoticeContent']['status'] = $status;

//			$this->CircularNoticeContent->saveCircularNoticeContent($data);
			if ($circularContent = $this->CircularNoticeContent->saveCircularNoticeContent($data)) {
				$url = NetCommonsUrl::actionUrl(array(
					'controller' => $this->params['controller'],
					'action' => 'view',
					'block_id' => $this->data['Block']['id'],
					'frame_id' => $this->data['Frame']['id'],
					'key' => $circularContent['CircularNoticeContent']['key']
				));
				$this->redirect($url);
				return;
			}

			$this->NetCommons->handleValidationError($this->CircularNoticeContent->validationErrors);

			unset($data['CircularNoticeContent']['status']);
			unset($content['CircularNoticeContent']['is_room_targeted_flag']);
			unset($content['CircularNoticeContent']['target_groups']);
			$data['CircularNoticeContent']['is_room_targeted_flag'] = $this->data['CircularNoticeContent']['is_room_targeted_flag'];
//			$data['CircularNoticeContent']['target_groups'] = $this->data['CircularNoticeContent']['target_groups'];
		}

		// FIXME: グループ情報を取得（共通待ち）
		$groups = $this->_getGroupsStub();

		$results = Hash::merge(
			$content, $data,
			['contentStatus' => null, 'groups' => $groups]
		);
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
		$this->set('frameId', $frameId);
		$this->set('blockId', $blockId);
	}

/**
 * edit action
 *
 * @param int $frameId frames.id
 * @param int $contentId circular_notice_content.id
 * @return void
 */
	public function edit($frameId = null, $key = null) {
		$userId = (int)$this->Auth->user('id');
		$this->initCircularNotice();
		$frameId = Current::read('Frame.id');
		$blockId = Current::read('Block.id');

		if (! $content = $this->CircularNoticeContent->getCircularNoticeContent($key, $userId)) {
			$this->throwBadRequest();
			return;
		}
//		$content['CircularNoticeContent']['is_room_targeted_flag'] =
//		$content['CircularNoticeContent']['is_room_targeted_flag'] ? array('1') : null;
		$content['CircularNoticeContent']['target_groups'] =
			explode(CircularNoticeComponent::SELECTION_VALUES_DELIMITER, $content['CircularNoticeContent']['target_groups']);

		$data = array();
		if ($this->request->is(array('post', 'put'))) {

			if (! $status = $this->Workflow->parseStatus()) {
				$this->throwBadRequest();
				return;
			}

			$data = $this->__parseRequestForSave();
			$data['CircularNoticeContent']['status'] = $status;
			
//			unset($data['CircularNoticeContent']['id']);	// 常に新規保存？
			$data['CircularNoticeContent']['key'] = $key;	// keyをここでセット（あとでWorkflow系の処理に置き換え？）

//			$this->CircularNoticeContent->saveCircularNoticeContent($data);
//			if ($this->handleValidationError($this->CircularNoticeContent->validationErrors)) {
//				$this->redirectByFrameId();
//				return;
//			}

//			$this->CircularNoticeContent->saveCircularNoticeContent($data);
			if ($circularContent = $this->CircularNoticeContent->saveCircularNoticeContent($data)) {
				$url = NetCommonsUrl::actionUrl(array(
					'controller' => $this->params['controller'],
					'action' => 'view',
					'block_id' => $this->data['Block']['id'],
					'frame_id' => $this->data['Frame']['id'],
					'key' => $circularContent['CircularNoticeContent']['key']
				));
				$this->redirect($url);
				return;
			}

			$this->NetCommons->handleValidationError($this->CircularNoticeContent->validationErrors);

			unset($data['CircularNoticeContent']['id']);
			unset($data['CircularNoticeContent']['status']);
			unset($content['CircularNoticeContent']['is_room_targeted_flag']);
			unset($content['CircularNoticeContent']['target_groups']);
			$data['CircularNoticeContent']['is_room_targeted_flag'] = $this->data['CircularNoticeContent']['is_room_targeted_flag'];
			$data['CircularNoticeContent']['target_groups'] = $this->data['CircularNoticeContent']['target_groups'];
		}

		// FIXME: グループ情報を取得（共通待ち）
		$groups = $this->_getGroupsStub();

		$results = Hash::merge(
			$content, $data,
			['contentStatus' => $content['CircularNoticeContent']['status'], 'groups' => $groups]
		);
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
		$this->set('frameId', $frameId);
		$this->set('blockId', $blockId);
	}

/**
 * delete action
 *
 * @param int $frameId frames.id
 * @param string $contentKey circular_notice_content.key
 * @return void
 */
	public function delete($frameId = null, $contentKey = null) {
		$this->initCircularNotice();

		if (! $this->request->isDelete()) {
			$this->throwBadRequest();
			return;
		}

		$this->CircularNoticeContent->deleteCircularNoticeContent($contentKey);
		$this->redirectByFrameId();
	}

/**
 * Get summary of answer.
 *
 * @param int $contentId circular_notice_content.id
 * @return array
 */
	private function __getAnswerSummary($contentId) {
		$answerSummary = array();

		$targetUsers = $this->CircularNoticeTargetUser->getCircularNoticeTargetUsers($contentId);
		foreach ($targetUsers as $targetUser) {
			$selectionValues = $targetUser['CircularNoticeTargetUser']['reply_selection_value'];
			if ($selectionValues) {
				$answers = explode(CircularNoticeComponent::SELECTION_VALUES_DELIMITER, $selectionValues);
				foreach ($answers as $answer) {
					if (! isset($answerSummary[$answer])) {
						$answerSummary[$answer] = 1;
					} else {
						$answerSummary[$answer]++;
					}
				}
			}
		}

		return $answerSummary;
	}

/**
 * Parsing request data for save
 *
 * @return mixed
 */
	private function __parseRequestForSave() {
		$data = $this->data;

		if ($this->data['CircularNoticeContent']['reply_type'] === CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT) {
			$data['CircularNoticeChoices'] = array();
		}

		if (! empty($this->data['CircularNoticeContent']['is_room_targeted_flag'])) {
			$data['CircularNoticeContent']['is_room_targeted_flag'] = true;
		} else {
			$data['CircularNoticeContent']['is_room_targeted_flag'] = false;
		}

		if (! empty($this->data['CircularNoticeContent']['target_groups'])) {
			$data['CircularNoticeContent']['target_groups'] =
				implode(CircularNoticeComponent::SELECTION_VALUES_DELIMITER, $data['CircularNoticeContent']['target_groups']);
		} else {
			$data['CircularNoticeContent']['target_groups'] = null;
		}

		if ($this->data['CircularNoticeContent']['reply_deadline_set_flag'] !== '1') {
			$data['CircularNoticeContent']['reply_deadline'] = null;
		}

		if (isset($data['CircularNoticeChoices'])) {
			foreach ($data['CircularNoticeChoices'] as $i => $choice) {
				$data['CircularNoticeChoices'][$i]['CircularNoticeChoice']['value'] =
					str_replace(CircularNoticeComponent::SELECTION_VALUES_DELIMITER, '', $choice['CircularNoticeChoice']['value']);
			}
		} else {
			$data['CircularNoticeChoices'] = array();
		}

		return $data;
	}
}
