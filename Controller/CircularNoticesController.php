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
		'NetCommons.NetCommonsWorkflow',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'contentCreatable' => array('add', 'edit', 'delete'),
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
	);

/**
 * index action
 *
 * @return void
 */
	public function index() {

		$this->initCircularNotice();

		// ログインユーザIDを取得
		$userId = (int)$this->Auth->user('id');

		// ログインユーザIDが存在する場合（回覧板はログイン前領域には表示させない）
		if (! empty($userId)) {

			// Paginator経由で一覧を取得
			$this->Paginator->settings = $this->CircularNoticeContent->getCircularNoticeContentsForPaginate(
				$this->viewVars['circularNoticeSetting']['key'],
				$this->viewVars['circularNoticeFrameSetting'],
				$this->params['named'],
				$userId
			);
			$circularNoticeContentList = $this->Paginator->paginate('CircularNoticeContent');

			// 各回覧データの閲覧／回答件数を取得
			foreach ($circularNoticeContentList as $i => $circularNoticeContent) {

				// 現時点／ログイン者に応じたステータスをセット
				$circularNoticeContentList[$i]['currentStatus'] = $circularNoticeContent['CircularNoticeContentCurrentStatus']['current_status'];
				$circularNoticeContentList[$i]['myStatus'] = $circularNoticeContent['CircularNoticeContentMyStatus']['my_status'];

				// 閲覧件数／回答件数を取得してセット
// FIXME: 表示件数が多い場合、クエリ発行回数がかなり増える
				$counts = $this->CircularNoticeTargetUser->getCircularNoticeTargetUserCount((int)$circularNoticeContent['CircularNoticeContent']['id']);
				$circularNoticeContentList[$i]['circularNoticeTargetCount'] = $counts['circularNoticeTargetCount'];
				$circularNoticeContentList[$i]['circularNoticeReadCount'] = $counts['circularNoticeReadCount'];
				$circularNoticeContentList[$i]['circularNoticeReplyCount'] = $counts['circularNoticeReplyCount'];
			}

			// 画面表示のためのデータを設定
			$circularNoticeContentList = $this->camelizeKeyRecursive($circularNoticeContentList);
			$this->set('circularNoticeContentList', $circularNoticeContentList);
		}
	}

/**
 * view action
 *
 * @param int $frameId frames.id
 * @param int $circularNoticeContentId circular_notice_content.id
 * @return void
 */
	public function view($frameId = null, $circularNoticeContentId = null) {

		$this->initCircularNotice();

		$userId = (int)$this->Auth->user('id');

		// 回覧を取得
		$circularNoticeContent = $this->CircularNoticeContent->getCircularNoticeContent($circularNoticeContentId);

		// ログイン者の回答を取得
		$myCircularNoticeTargetUser = $this->CircularNoticeTargetUser->getMyCircularNoticeTargetUser(
			$circularNoticeContentId,
			$userId
		);

		// 未読の場合は既読に更新
		if (! $myCircularNoticeTargetUser['CircularNoticeTargetUser']['read_flag']) {
			if (!$this->CircularNoticeTargetUser->saveRead($myCircularNoticeTargetUser['CircularNoticeTargetUser']['id'])) {
				// FIXME: バリデーション失敗時の処理が必要
			}
		}

		// 回答の登録／更新
		if ($this->request->is('post')) {

			$replySelectionValue = '';
			if ($circularNoticeContent['CircularNoticeContent']['reply_type'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION) {
				$replySelectionValue = $this->data['CircularNoticeTargetUser']['reply_selection_value'];
			} else if ($circularNoticeContent['CircularNoticeContent']['reply_type'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION) {
				$replySelectionValue = implode(CircularNoticeComponent::SELECTION_VALUES_DELIMITER, $this->data['CircularNoticeTargetUser']['reply_selection_value']);
			}

			$data = Hash::merge(
				$this->data,
				['CircularNoticeTargetUser' => [
					'reply_flag' => true,
					'reply_datetime' => date('Y-m-d H:i:s'),
					'reply_selection_value' => $replySelectionValue,
				]]
			);

			if (! $this->CircularNoticeTargetUser->saveCircularNoticeTargetUser($data)) {
				// FIXME: バリデーション失敗時の処理が必要
			}

			// FIXME: こうしておかないと２回目のrequest->is('post')がfalseになるため要確認
			$this->redirect($this->request->here);
			return;
		}

		// ログイン者の回答を再取得（更新されている可能性があるため）
		$myCircularNoticeTargetUser = $this->CircularNoticeTargetUser->getMyCircularNoticeTargetUser(
			$circularNoticeContentId,
			$userId
		);

		// 回覧の閲覧件数／回答件数を取得
		$counts = $this->CircularNoticeTargetUser->getCircularNoticeTargetUserCount($circularNoticeContentId);

		// Paginator経由で回答先一覧を取得
		$this->Paginator->settings = $this->CircularNoticeTargetUser->getCircularNoticeTargetUsersForPaginator(
			$circularNoticeContentId,
			$this->params['named'],
			$userId
		);
		$circularNoticeTargetUsers = $this->Paginator->paginate('CircularNoticeTargetUser');

		// 択一選択と選択方式の回覧の場合は回答集計用に回答先一覧を取得
		$answersSummary = array();
		if (
			$circularNoticeContent['CircularNoticeContent']['reply_type'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION ||
			$circularNoticeContent['CircularNoticeContent']['reply_type'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION
		) {
			$circularNoticeTargetUsersForSummary = $this->CircularNoticeTargetUser->getCircularNoticeTargetUsers($circularNoticeContentId);
			foreach ($circularNoticeTargetUsersForSummary as $circularNoticeTargetUser) {
				$selectionValues = $circularNoticeTargetUser['CircularNoticeTargetUser']['reply_selection_value'];
				if ($selectionValues) {
					$answers = explode(CircularNoticeComponent::SELECTION_VALUES_DELIMITER, $selectionValues);
					foreach ($answers as $answer) {
						if (! isset($answersSummary[$answer])) {
							$answersSummary[$answer] = 1;
						} else {
							$answersSummary[$answer]++;
						}
					}
				}
			}
		}

		// 画面表示用に一部データを整形
		$myCircularNoticeTargetUser['CircularNoticeTargetUser']['reply_selection_value'] =
			explode(CircularNoticeComponent::SELECTION_VALUES_DELIMITER, $myCircularNoticeTargetUser['CircularNoticeTargetUser']['reply_selection_value']);
		foreach ($circularNoticeTargetUsers as $i => $circularNoticeTargetUser) {
			$circularNoticeTargetUsers[$i]['CircularNoticeTargetUser']['reply_selection_value'] =
				explode(CircularNoticeComponent::SELECTION_VALUES_DELIMITER, $circularNoticeTargetUser['CircularNoticeTargetUser']['reply_selection_value']);
		}

		$results = Hash::merge(
			$circularNoticeContent,
			$counts,
			[
				'MyAnswer' => $myCircularNoticeTargetUser,
				'CircularNoticeTargetUsers' => $circularNoticeTargetUsers,
				'AnswersSummary' => $answersSummary,
			]
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

		$this->view = 'edit';

		$this->initCircularNotice();

		$circularNoticeContent = $this->CircularNoticeContent->create(array(
			'is_room_targeted_flag' => false,
			'target_groups' => ''
		));
		$circularNoticeContent['CircularNoticeChoice'] = array();

		$data = array();
		if ($this->request->is('post')) {

			if (! $status = $this->NetCommonsWorkflow->parseStatus()) {
				$this->throwBadRequest();
				return;
			}

			$data = $this->__parseRequestForSave();
			$data['CircularNoticeContent']['status'] = $status;

			$this->CircularNoticeContent->saveCircularNoticeContent($data);
			if ($this->handleValidationError($this->CircularNoticeContent->validationErrors)) {
				$this->redirectByFrameId();
				return;
			}

// FIXME: バリデーションエラーはこうやってひっかけるっぽい・・・のでちょっと処理を整理しないといけない
			unset($data['CircularNoticeContent']['id']);
			unset($data['CircularNoticeContent']['status']);
			$data['CircularNoticeContent']['is_room_targeted_flag'] = $this->data['CircularNoticeContent']['is_room_targeted_flag'];
			$data['CircularNoticeContent']['target_groups'] = $this->data['CircularNoticeContent']['target_groups'];
		}

		// FIXME: グループ情報を取得（共通待ち）
		$groups = $this->getGroupsStub();

		$results = Hash::merge(
			$circularNoticeContent, $data,
			['contentStatus' => null, 'groups' => $groups]
		);
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
	}

/**
 * edit action
 *
 * @param int $frameId frames.id
 * @param int $circularNoticeContentId circular_notice_content.id
 * @return void
 */
// FIXME: 基準はidか？keyか？
	public function edit($frameId = null, $circularNoticeContentId = null) {

		$this->initCircularNotice();

		if (! $circularNoticeContent = $this->CircularNoticeContent->getCircularNoticeContent($circularNoticeContentId)) {
			$this->throwBadRequest();
			return;
		}

		$data = array();
		if ($this->request->is('post')) {

			if (! $status = $this->NetCommonsWorkflow->parseStatus()) {
				$this->throwBadRequest();
				return;
			}

			// リクエストから保存用のデータを生成
			$data = $this->__parseRequestForSave();
			$data['CircularNoticeContent']['status'] = $status;

			$this->CircularNoticeContent->saveCircularNoticeContent($data);
			if ($this->handleValidationError($this->CircularNoticeContent->validationErrors)) {
				$this->redirectByFrameId();
				return;
			}

// FIXME: バリデーションエラーはこうやってひっかけるっぽい・・・のでちょっと処理を整理しないといけない
			$data['CircularNoticeContent']['is_room_targeted_flag'] = $this->data['CircularNoticeContent']['is_room_targeted_flag'];
			$circularNoticeContent['CircularNoticeContent']['target_groups'] = $data['CircularNoticeContent']['target_groups'];
			unset($data['CircularNoticeContent']['status']);
			unset($data['CircularNoticeContent']['target_groups']);
		}

		// FIXME: グループ情報を取得（共通待ち）
		$groups = $this->getGroupsStub();

		// 画面表示用に一部データを整形
		$circularNoticeContent['CircularNoticeContent']['is_room_targeted_flag'] =
			$circularNoticeContent['CircularNoticeContent']['is_room_targeted_flag'] ? array('1') : null;
		$circularNoticeContent['CircularNoticeContent']['target_groups'] =
			explode(CircularNoticeComponent::SELECTION_VALUES_DELIMITER, $circularNoticeContent['CircularNoticeContent']['target_groups']);

		$results = Hash::merge(
			$circularNoticeContent, $data,
			['contentStatus' => null, 'groups' => $groups]
		);
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
	}

/**
 * delete action
 *
 * @param int $frameId frames.id
 * @param string $circularNoticeContentKey circular_notice_content.key
 * @return void
 */
// FIXME: 基準はidか？keyか？
	public function delete($frameId = null, $circularNoticeContentKey = null) {

		$this->initCircularNotice();

		if (! $this->request->isDelete()) {
			$this->throwBadRequest();
			return;
		}

		$this->CircularNoticeContent->deleteCircularNoticeContent($circularNoticeContentKey);
		$this->redirectByFrameId();
		return;
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
			$data['CircularNoticeContent']['target_groups'] = implode(CircularNoticeComponent::SELECTION_VALUES_DELIMITER, $data['CircularNoticeContent']['target_groups']);
		} else {
			$data['CircularNoticeContent']['target_groups'] = NULL;
		}

		if ($this->data['CircularNoticeContent']['reply_deadline_set_flag'] !== '1') {
			$data['CircularNoticeContent']['reply_deadline'] = null;
		}

		foreach ($data['CircularNoticeChoices'] as $i => $choice) {
			$data['CircularNoticeChoices'][$i]['CircularNoticeChoice']['value'] =
				str_replace(CircularNoticeComponent::SELECTION_VALUES_DELIMITER, '', $choice['CircularNoticeChoice']['value']);
		}

		return $data;
	}
}
