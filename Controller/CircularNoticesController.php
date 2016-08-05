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
		'CircularNotices.CircularNoticeFrameSetting',
		'CircularNotices.CircularNoticeSetting',
		'CircularNotices.CircularNoticeContent',
		'CircularNotices.CircularNoticeChoice',
		'CircularNotices.CircularNoticeTargetUser',
		'User' => 'Users.User',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.Permission' => array(
			//アクセスの権限
			'allow' => array(
				'index,view,downloads' => 'content_readable',
				'add,edit,delete' => 'content_creatable',
			),
		),
		'Paginator',
		'UserAttributes.UserAttributeLayout',
		'CircularNotices.CircularNotice',
		'NetCommons.NetCommonsTime',
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
		'NetCommons.DisplayNumber',
		'Workflow.Workflow',
		'Groups.GroupUserList',
		'NetCommons.TitleIcon',
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
			$counts = $this->CircularNoticeTargetUser
				->getCircularNoticeTargetUserCount((int)$content['CircularNoticeContent']['id']);
			$contents[$i]['target_count'] = $counts['targetCount'];
			$contents[$i]['read_count'] = $counts['readCount'];
			$contents[$i]['reply_count'] = $counts['replyCount'];
		}

		// 画面表示のためのデータを設定
		$this->set('circularNoticeContents', $contents);
	}

/**
 * view action
 *
 * @return void
 */
	public function view() {
		$userId = Current::read('User.id');
		$contentKey = $this->request->params['key'];
		$this->initCircularNotice();

		// 回覧を取得
		$content = $this->CircularNoticeContent->getCircularNoticeContent($contentKey, $userId);
		if (! $content) {
			return $this->throwBadRequest();
		}
		$contentId = $content['CircularNoticeContent']['id'];
		$myTargetUser = array();

		// ログイン者が回覧先に含まれる
		if (!empty($content['MyCircularNoticeTargetUser']['user_id'])) {
			// 既読に更新
			$this->CircularNoticeTargetUser->saveRead($contentId, $userId);

			// ログイン者の回答を取得して整形
			$myTargetUser = array('CircularNoticeTargetUser' => $content['MyCircularNoticeTargetUser']);
			$myTargetUser['CircularNoticeTargetUser']['origin_reply_text_value'] =
				$myTargetUser['CircularNoticeTargetUser']['reply_text_value'];
			$myTargetUser['CircularNoticeTargetUser']['origin_reply_selection_value'] =
				$myTargetUser['CircularNoticeTargetUser']['reply_selection_value'];
		}

		// 回覧の閲覧件数／回答件数を取得
		$counts = $this->CircularNoticeTargetUser->getCircularNoticeTargetUserCount($contentId);

		// Paginator経由で回答先一覧を取得
		$this->Paginator->settings = $this->CircularNoticeTargetUser
			->getCircularNoticeTargetUsersForPaginator($contentId, $this->params['named'], $userId);
		$targetUsers = $this->Paginator->paginate('CircularNoticeTargetUser');

		// 回答を集計
		$answersSummary = $this->CircularNoticeContent->getAnswerSummary($contentId);

		// 回答の登録／更新
		if ($this->request->is(array('post', 'put'))) {

			$replyTextValue = '';
			$replySelectionValue = '';
			if ($content['CircularNoticeContent']['reply_type'] ==
				CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT) {
				$replyTextValue = $this->data['CircularNoticeTargetUser']['reply_text_value'];
			} elseif ($content['CircularNoticeContent']['reply_type'] ==
				CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION) {
				$replySelectionValue = $this->data['CircularNoticeTargetUser']['reply_selection_value'];
			} elseif ($content['CircularNoticeContent']['reply_type'] ==
				CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION) {
				if ($this->data['CircularNoticeTargetUser']['reply_selection_value']) {
					$replySelectionValue = implode(CircularNoticeComponent::SELECTION_VALUES_DELIMITER,
						$this->data['CircularNoticeTargetUser']['reply_selection_value']);
				}
			}

			$data = Hash::merge(
				$this->data,
				['CircularNoticeTargetUser' => ['is_reply' => true, 'reply_datetime' => date('Y-m-d H:i:s'),
					'reply_text_value' => $replyTextValue, 'reply_selection_value' => $replySelectionValue]]
			);

			if ($this->CircularNoticeTargetUser->saveCircularNoticeTargetUser($data)) {
				//新着データを回答済みにする
				$this->CircularNoticeContent->saveTopicUserStatus($content, true);

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
		} else {
			//新着データを既読にする
			$this->CircularNoticeContent->saveTopicUserStatus($content);
		}

		$results = Hash::merge(
			$counts,
			['myAnswer' => $myTargetUser, /*'CircularNoticeTargetUsers' => $targetUsers,*/
				'answersSummary' => $answersSummary]
		);
		$this->set('circularNoticeContent', $content['CircularNoticeContent']);
		$this->set('circularNoticeChoice', $content['CircularNoticeChoice']);
		$this->set('circularNoticeTargetUsers', $targetUsers);
		$this->set($results);
	}

/**
 * add action
 *
 * @return void
 */
	public function add() {
		$this->view = 'edit';
		$this->helpers[] = 'Users.UserSearch';

		$this->initCircularNotice();

		$content = $this->CircularNoticeContent->create(array(
			'is_room_target' => true,
		));
		$content['CircularNoticeChoice'] = array();

		$data = array();
		if ($this->request->is('post')) {

			$data = $this->__parseRequestForSave();
			$data['CircularNoticeContent']['status'] = $this->Workflow->parseStatus();

			if ($circularContent = $this->CircularNoticeContent->saveCircularNoticeContent($data)) {
				$url = NetCommonsUrl::actionUrl(array(
					'controller' => $this->params['controller'],
					'action' => 'view',
					'frame_id' => $this->data['Frame']['id'],
					'block_id' => $this->data['Block']['id'],
					'key' => $circularContent['CircularNoticeContent']['key']
				));
				$this->redirect($url);
				return;
			} else {
				// 回答の選択肢を保持
				$content['CircularNoticeChoice'] = Hash::extract($data,
					'CircularNoticeChoices.{n}.CircularNoticeChoice');

				// ユーザ選択状態を保持
				$this->CircularNotice->setSelectUsers($this);
			}
			$this->NetCommons->handleValidationError($this->CircularNoticeContent->validationErrors);

			unset($data['CircularNoticeContent']['status']);
			$data['CircularNoticeContent']['is_room_target'] =
				$this->data['CircularNoticeContent']['is_room_target'];
		} else {
			if (!isset($data['CircularNoticeContent']['is_room_target'])
					|| $data['CircularNoticeContent']['is_room_target']) {
				// 自分自身を取得
				$selectUsers = array(Current::read('User.id'));
				$this->request->data['selectUsers'] = array();
				foreach ($selectUsers as $userId) {
					$this->request->data['selectUsers'][] = $this->User->getUser($userId);
				}
			}
		}

		$results = Hash::merge(
			$content, $data,
			['contentStatus' => null]
		);
		$results = $this->NetCommonsTime->toUserDatetimeArray(
			$results,
			array(
				'CircularNoticeContent.publish_start',
				'CircularNoticeContent.publish_end',
				'CircularNoticeContent.reply_deadline',
			));
		$this->set('circularNoticeContent', $results['CircularNoticeContent']);
		$this->set('circularNoticeChoice', $results['CircularNoticeChoice']);
	}

/**
 * edit action
 *
 * @return void
 */
	public function edit() {
		$userId = Current::read('User.id');
		$this->initCircularNotice();
		$this->helpers[] = 'Users.UserSearch';
		$key = $this->request->params['key'];

		if (! $content = $this->CircularNoticeContent->getCircularNoticeContent($key, $userId)) {
			return $this->throwBadRequest();
		}

		$data = array();
		if ($this->request->is(array('post', 'put'))) {

			$data = $this->__parseRequestForSave();
			$data['CircularNoticeContent']['status'] = $this->Workflow->parseStatus();

			$data['CircularNoticeContent']['key'] = $key;	// keyをここでセット
			$data['CircularNoticeContent']['public_type'] = $content['CircularNoticeContent']['public_type'];

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
			} else {
				// 回答の選択肢を保持
				$content['CircularNoticeChoice'] = Hash::extract($data,
					'CircularNoticeChoices.{n}.CircularNoticeChoice');

				// ユーザ選択状態を保持
				$this->CircularNotice->setSelectUsers($this);
			}
			$this->NetCommons->handleValidationError($this->CircularNoticeContent->validationErrors);

			unset($data['CircularNoticeContent']['id']);
			unset($data['CircularNoticeContent']['status']);
			$data['CircularNoticeContent']['is_room_target'] =
				$this->data['CircularNoticeContent']['is_room_target'];
		} else {
			if ($content['CircularNoticeContent']['is_room_target']) {
				// 自分自身を取得
				$selectUsers = array(Current::read('User.id'));
			} else {
				$selectUsers = Hash::extract($content['CircularNoticeTargetUser'], '{n}.user_id');
			}
			$this->request->data['selectUsers'] = array();
			foreach ($selectUsers as $userId) {
				$this->request->data['selectUsers'][] = $this->User->getUser($userId);
			}
		}

		$results = Hash::merge(
			$content, $data,
			['contentStatus' => $content['CircularNoticeContent']['status']]
		);
		$results = $this->NetCommonsTime->toUserDatetimeArray(
			$results,
			array(
				'CircularNoticeContent.publish_start',
				'CircularNoticeContent.publish_end',
				'CircularNoticeContent.reply_deadline',
			));
		$this->set('circularNoticeContent', $results['CircularNoticeContent']);
		$this->set('circularNoticeChoice', $results['CircularNoticeChoice']);
	}

/**
 * delete action
 *
 * @return void
 */
	public function delete() {
		$contentKey = $this->request->params['key'];

		$this->initCircularNotice();

		if (! $this->request->is('delete')) {
			return $this->throwBadRequest();
		}

		$this->CircularNoticeContent->deleteCircularNoticeContent($contentKey);
		$this->redirect(NetCommonsUrl::backToPageUrl());
	}

/**
 * download
 *
 * @return file
 * @throws InternalErrorException
 */
	public function download() {
		App::uses('TemporaryFolder', 'Files.Utility');
		App::uses('CsvFileWriter', 'Files.Utility');
		App::uses('ZipDownloader', 'Files.Utility');

		try {
			$userId = Current::read('User.id');
			$contentKey = $this->request->params['key'];
			$this->initCircularNotice();

			// 回覧を取得
			$content = $this->CircularNoticeContent->getCircularNoticeContent($contentKey, $userId);
			if (! $content) {
				return $this->throwBadRequest();
			}
			$contentId = $content['CircularNoticeContent']['id'];

			// Paginator経由で回答先一覧を取得
			$this->Paginator->settings = $this->CircularNoticeTargetUser
				->getCircularNoticeTargetUsersForPaginator($contentId, $this->params['named'], $userId, 0);
			$targetUsers = $this->Paginator->paginate('CircularNoticeTargetUser');

			$tmpFolder = new TemporaryFolder();
			$csvFile = new CsvFileWriter(array(
				'folder' => $tmpFolder->path
			));

			// ヘッダ取得
			$header = $this->CircularNotice->getTargetUserHeader();
			$csvFile->add($header);

			// 回答データ整形
			$content = $content['CircularNoticeContent'];
			foreach ($targetUsers as $targetUser) {
				$answer = null;
				switch ($content['reply_type']) {
					case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT:
						$answer = $targetUser['CircularNoticeTargetUser']['reply_text_value'];
						break;
					case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION:
					case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION:
						$selectionValues = explode(CircularNoticeComponent::SELECTION_VALUES_DELIMITER,
							$targetUser['CircularNoticeTargetUser']['reply_selection_value']);
						$answer = implode('、', $selectionValues);
						break;
				}

				if (! $targetUser['CircularNoticeTargetUser']['read_datetime']) {
					$readDatetime = __d('circular_notices', 'Unread');
				} else {
					$readDatetime = $this->CircularNotice
						->getDisplayDateFormat($targetUser['CircularNoticeTargetUser']['read_datetime']);
				}
				if (! $targetUser['CircularNoticeTargetUser']['reply_datetime']) {
					$replyDatetime = __d('circular_notices', 'Unreply');
				} else {
					$replyDatetime = $this->CircularNotice
						->getDisplayDateFormat($targetUser['CircularNoticeTargetUser']['reply_datetime']);
				}
				$data = array(
					h($targetUser['User']['handlename']),
					h($readDatetime),
					h($replyDatetime),
					h($answer),
				);
				$csvFile->add($data);
			}
		} catch (Exception $e) {
			$this->NetCommons->setFlashNotification(__d('circular_notices', 'download error'),
				array('interval' => NetCommonsComponent::ALERT_VALIDATE_ERROR_INTERVAL));
			$this->redirect(NetCommonsUrl::actionUrl(array(
				'controller' => 'circular_notices',
				'action' => 'view',
				'block_id' => Current::read('Block.id'),
				'frame_id' => Current::read('Frame.id'),
				'key' => $contentKey)));
			return false;
		}
		$this->autoRender = false;
		$fileName = $content['subject'] . CircularNoticeComponent::EXPORT_FILE_EXTENSION;
		return $csvFile->download($fileName);
	}

/**
 * Parsing request data for save
 *
 * @return mixed
 */
	private function __parseRequestForSave() {
		$data = $this->data;

		if ($this->data['CircularNoticeContent']['reply_type'] ===
			CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT) {
			$data['CircularNoticeChoices'] = array();
		}

		if (!empty($this->data['CircularNoticeContent']['is_room_target'])) {
			$data['CircularNoticeContent']['is_room_target'] = true;
		} else {
			$data['CircularNoticeContent']['is_room_target'] = false;
		}

		if ($this->data['CircularNoticeContent']['use_reply_deadline'] !== '1') {
			$data['CircularNoticeContent']['reply_deadline'] = null;
		}

		return $data;
	}
}
