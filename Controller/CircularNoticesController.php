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
		'Paginator' => array('className' => 'NetCommons.AppPaginator'),
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
		$this->CircularNotice->setCircularNoticeErrors($this);
		$this->CircularNotice->setCircularNoticeDatas($this);
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
		'AuthorizationKeys.AuthKeyPopupButton',
		'CircularNotices.CircularNotice',
	);

/**
 * index action
 *
 * @return void
 */
	public function index() {
		if (! $this->CircularNotice->initCircularNotice($this)) {
			return;
		}

		// コンテンツステータスの絞り込み値チェック
		if (isset($this->params['named']['content_status'])
				&& ! $this->CircularNotice->existsContentStatus($this->params['named']['content_status'])) {
			return $this->throwBadRequest();
		}

		// 回答状況の絞り込み値チェック
		if (isset($this->params['named']['reply_status'])
				&& ! $this->CircularNotice->existsReplyStatus($this->params['named']['reply_status'])) {
			return $this->throwBadRequest();
		}

		// ソートの選択肢
		$sortOptions = array(
			'CircularNoticeContent.modified.desc' => array(
				'label' => __d('net_commons', 'Newest'),
				'sort' => 'CircularNoticeContent.modified',
				'direction' => 'desc'
			),
			'CircularNoticeContent.created.asc' => array(
				'label' => __d('net_commons', 'Oldest'),
				'sort' => 'CircularNoticeContent.created',
				'direction' => 'asc'
			),
			'CircularNoticeContent.subject.asc' => array(
				'label' => __d('net_commons', 'Title'),
				'sort' => 'CircularNoticeContent.subject',
				'direction' => 'asc'
			),
			'CircularNoticeContent.reply_deadline.desc' => array(
				'label' => __d('circular_notices', 'Change Sort Order to Reply Deadline'),
				'sort' => 'CircularNoticeContent.reply_deadline',
				'direction' => 'desc'
			),
		);
		$this->set('sortOptions', $sortOptions);

		$currentSort = Hash::get($this->params['named'], 'sort', 'CircularNoticeContent.modified');
		$currentDirection = Hash::get($this->params['named'], 'direction', 'desc');
		if (! isset($sortOptions[$currentSort . '.' . $currentDirection])) {
			$currentSort = 'CircularNoticeContent.modified';
			$currentDirection = 'desc';
		}
		$this->set('currentSort', $currentSort);
		$this->set('currentDirection', $currentDirection);

		// Paginator経由で一覧を取得
		$this->Paginator->settings = $this->CircularNoticeContent->getCircularNoticeContentsForPaginate(
			$this->viewVars['circularNoticeSetting']['CircularNoticeSetting']['key'],
			Current::read('User.id'),
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
		$this->CircularNotice->initCircularNotice($this);

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
		} else {
			// 回覧先に含まれておらず編集権限がなければ参照不可
			if ($this->CircularNoticeContent->canEditWorkflowContent($content) === false) {
				return $this->throwBadRequest();
			}
		}

		// 回覧の閲覧件数／回答件数を取得
		$counts = $this->CircularNoticeTargetUser->getCircularNoticeTargetUserCount($contentId);

		// Paginator経由で回覧先一覧を取得
		$this->Paginator->settings = $this->CircularNoticeTargetUser
			->getCircularNoticeTargetUsersForPaginator($contentId, $this->params['named'], $userId);
		$targetUsers = $this->Paginator->paginate('CircularNoticeTargetUser');

		// 回答を集計
		$answersSummary = $this->CircularNoticeTargetUser->getAnswerSummary($contentId);

		// 回答エラー時は入力値を保持
		if (isset($this->viewVars['circularNoticeDatas'])) {
			$inputData = $this->viewVars['circularNoticeDatas'];
			$replyTextValue = '';
			$replySelectionValue = '';
			if ($content['CircularNoticeContent']['reply_type'] ==
				CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT) {
				$replyTextValue = $inputData['CircularNoticeTargetUser']['reply_text_value'];
			} elseif ($content['CircularNoticeContent']['reply_type'] ==
				CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION) {
				$replySelectionValue = $inputData['CircularNoticeTargetUser']['reply_selection_value'];
			} elseif ($content['CircularNoticeContent']['reply_type'] ==
				CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION) {
				if (is_array($inputData['CircularNoticeTargetUser']['reply_selection_value'])) {
					$replySelectionValue = implode(CircularNoticeComponent::SELECTION_VALUES_DELIMITER,
						$inputData['CircularNoticeTargetUser']['reply_selection_value']);
				}
			}
			$myTargetUser['CircularNoticeTargetUser']['reply_text_value'] = $replyTextValue;
			$myTargetUser['CircularNoticeTargetUser']['reply_selection_value'] = $replySelectionValue;
		} else {
			// 新着データを既読にする
			$this->CircularNoticeContent->saveTopicUserStatus($content);
		}

		// コンテンツ作成者情報をセット
		$createdUser = $this->User->getUser($content['CircularNoticeContent']['created_user']);
		$this->set('createdUser', $createdUser);

		$results = Hash::merge(
			$counts,
			['myAnswer' => $myTargetUser,
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

		$this->CircularNotice->initCircularNotice($this);

		$content = $this->CircularNoticeContent->create(array(
			'is_room_target' => true,
		));
		$content['CircularNoticeChoice'] = array();

		$data = array();
		if ($this->request->is('post')) {

			$data = $this->__parseRequestForSave();
			$data['CircularNoticeContent']['status'] = $this->Workflow->parseStatus();

			// set language_id
			$data['CircularNoticeContent']['language_id'] = Current::read('Language.id');

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
			// 回覧開始日にDEFAULT値として現在日持を設定
			$content['CircularNoticeContent']['publish_start'] = date('Y-m-d H:i:s');
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
		$this->CircularNotice->initCircularNotice($this);
		$this->helpers[] = 'Users.UserSearch';
		$key = $this->request->params['key'];

		$content = $this->CircularNoticeContent->getCircularNoticeContent($key, $userId);
		if (! $content) {
			return $this->throwBadRequest();
		}

		if ($this->CircularNoticeContent->canEditWorkflowContent($content) === false) {
			return $this->throwBadRequest();
		}

		$data = array();
		if ($this->request->is(array('post', 'put'))) {

			$data = $this->__parseRequestForSave();
			$data['CircularNoticeContent']['status'] = $this->Workflow->parseStatus();

			$data['CircularNoticeContent']['key'] = $key;	// keyをここでセット
			$data['CircularNoticeContent']['public_type'] = $content['CircularNoticeContent']['public_type'];

			// set language_id
			$data['CircularNoticeContent']['language_id'] = Current::read('Language.id');

			$data['oldCircularNoticeContentId'] = $data['CircularNoticeContent']['id'];
			unset($data['CircularNoticeContent']['id']);

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
		$this->request->allowMethod('post', 'delete');
		$userId = Current::read('User.id');
		$contentKey = $this->request->params['key'];

		$this->CircularNotice->initCircularNotice($this);

		// 権限チェック
		// ※回覧板の場合は承認ワークフローがなく、編集可能であれば削除を許可
		$content = $this->CircularNoticeContent->getCircularNoticeContent($contentKey, $userId);
		//if ($this->CircularNoticeContent->canDeleteWorkflowContent($content) === false) {
		if ($this->CircularNoticeContent->canEditWorkflowContent($content) === false) {
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

		$zipPassword = $this->__getCompressPassword();
		if ($zipPassword === false) {
			return false;
		}

		try {
			$userId = Current::read('User.id');
			$contentKey = $this->request->params['key'];
			$this->CircularNotice->initCircularNotice($this);

			// 回覧を取得
			$content = $this->CircularNoticeContent->getCircularNoticeContent($contentKey, $userId);
			if (! $content) {
				return $this->throwBadRequest();
			}
			$contentId = $content['CircularNoticeContent']['id'];

			// Paginator経由で回覧先一覧を取得
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
				$answer = $this->__parseAnswer($content['reply_type'], $targetUser);

				$readDatetime = __d('circular_notices', 'Unread');
				if ($targetUser['CircularNoticeTargetUser']['read_datetime']) {
					$readDatetime = $this->CircularNotice
						->getDisplayDateFormat($targetUser['CircularNoticeTargetUser']['read_datetime']);
				}
				$replyDatetime = __d('circular_notices', 'Unreply');
				if ($targetUser['CircularNoticeTargetUser']['reply_datetime']) {
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
		$zipFileName = $content['subject'] . CircularNoticeComponent::EXPORT_COMPRESS_FILE_EXTENSION;
		$downloadFileName = $content['subject'] . CircularNoticeComponent::EXPORT_FILE_EXTENSION;
		return $csvFile->zipDownload(rawurlencode($zipFileName), $downloadFileName, $zipPassword);
	}

/**
 * Parse answer data
 *
 * @param string $replyType 回答種別
 * @param array $targetUser 回答者
 * @return null|string
 */
	private function __parseAnswer($replyType, $targetUser) {
		$answer = null;
		switch ($replyType) {
			case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT:
				$answer = $targetUser['CircularNoticeTargetUser']['reply_text_value'];
				break;
			case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION:
			case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION:
				$selectionValues = explode(CircularNoticeComponent::SELECTION_VALUES_DELIMITER,
					$targetUser['CircularNoticeTargetUser']['reply_selection_value']);
				$answer = implode(__d('circular_notices', 'Answer separator'), $selectionValues);
				break;
		}
		return $answer;
	}

/**
 * Get compress password
 *
 * @return mixed
 */
	private function __getCompressPassword() {
		if (isset($this->request->data['AuthorizationKey']) &&
			$this->request->data['AuthorizationKey']['authorization_key'] !== ''
		) {
			return $this->request->data['AuthorizationKey']['authorization_key'];
		}

		// エラー
		$this->NetCommons->setFlashNotification(
			__d('circular_notices', 'Setting of password is required always to download answers.'),
			array('interval' => NetCommonsComponent::ALERT_VALIDATE_ERROR_INTERVAL)
		);
		$this->redirect(NetCommonsUrl::actionUrl(array(
			'controller' => 'circular_notices',
			'action' => 'view',
			'block_id' => Current::read('Block.id'),
			'key' => $this->request->params['key'],
			'frame_id' => Current::read('Frame.id')
		)));
		return false;
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
		return $data;
	}
}
