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
		'CircularNotices.CircularNotice',
		'CircularNotices.CircularNoticeContent',
		'CircularNotices.CircularNoticeChoice',
		'CircularNotices.CircularNoticeContent',
		'CircularNotices.CircularNoticeTargetUser',
		'Comments.Comment',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsBlock',
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsWorkflow',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'contentEditable' => array('indexLatest', 'indexSetting', 'edit', 'delete'),
				'contentCreatable' => array('token', 'edit', 'delete'),
			),
		),
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
 * index method
 *
 * @return void
 */
	public function index($frameId = null, $currentPage = 1, $displayOrder = 0,
								$visibleRowCount = 10, $narrowDownParams = 0) {
		$this->__initCircularNotice();

		// プルダウン設定値を画面に渡す
		$this->set('displayOrder', $displayOrder);
		$this->set('visibleRowCount', $visibleRowCount);
		$this->set('narrowDownParams', $narrowDownParams);

		// 現在のページ番号を画面に渡す
		$this->set('currentPage', $currentPage);
	}

/**
 * view method
 *
 * @param int $frameId frames.id
 * @param int $circularNoticeContentId circular_notice_content.id
 * @return void
 */
	public function view($frameId, $circularNoticeContentId) {
		// 回答の登録
		if ($this->request->isPost()) {
			// 回答の登録
			$this->CircularNoticeTargetUser->saveReplyValue($this->data['CircularNoticeTargetUser'], (int)$this->Auth->user('id'));

			// 一覧画面へ遷移
			$this->redirectByFrameId();
			return;
		}
		else {
			// 既読状態に設定
			$this->CircularNoticeTargetUser->setReadYet($circularNoticeContentId, (int)$this->Auth->user('id'));
		}

		// 回覧関連データを取得
		$result = $this->CircularNoticeContent->getCircularNoticeContentForView($circularNoticeContentId, (int)$this->Auth->user('id'));

		// 画面表示のためのデータを設定
		$result = $this->camelizeKeyRecursive($result);
		$this->set('circularNoticeContent', $result['circularNoticeContent']);
		$this->set('circularNoticeChoices', $result['circularNoticeChoice']);
		$this->set('circularNoticeTargetUsers', $result['circularNoticeTargetUser']);
	}

/**
 * edit method
 *
 * @param int $frameId frames.id
 * @param int $circularNoticeContentId circular_notice_content.id
 * @return void
 */
	public function edit($frameId = null, $circularNoticeContentId = null) {
		// 登録・編集画面表示
		if (! $this->request->isPost()) {
			$result = null;

			// 編集の場合
			if($circularNoticeContentId) {
				$result = $this->CircularNoticeContent->getCircularNoticeContentForEdit($circularNoticeContentId);
			}
			// 新規登録の場合
			else {
				// テーブル定義のデフォルト値でレコードを作成（コミットはされない）
				$result = $this->CircularNoticeContent->create();
			}

			//グループ情報を取得（Todo: 共通待ち)
			$groups = $this->__getGroupId($this->viewVars['roomId']);

			// 画面表示のためのデータを設定
			$result = $this->camelizeKeyRecursive($result);
			$this->set('circularNoticeContent', $result['circularNoticeContent']);
			$this->set('contentStatus', $result['circularNoticeContent']['status']);

			$groups = $this->camelizeKeyRecursive($groups);
			$this->set('groups', $groups);
		}
		// 登録処理
		else {
			// ステータスを取得
			if (!$status = $this->NetCommonsWorkflow->parseStatus()) {
				return;
			}

			// 回覧関連データを登録
			$result = $this->CircularNoticeContent->saveCircularNoticeContent($this->data, $status);

			// 一覧画面へ遷移
//			$this->redirectByFrameId();
			return;
		}
	}

/**
 * __initCircularNotice method
 *
 * @return void
 */
	private function __initCircularNotice() {
		// ブロックが存在しない場合（新規配置）
		if (empty($this->viewVars['blockId'])) {

			// 回覧板の初期設定を実施
			$results = $this->CircularNotice->saveInitialSetting($this->viewVars['frameId'], $this->viewVars['frameKey']);

			// 画面表示のためデータを設定
			$results = $this->camelizeKeyRecursive($results);
			$this->set('circularNoticeFrameSetting', $results['circularNoticeFrameSetting']);
			$this->set('circularNotice', $results['circularNotice']);

			// 設定画面を表示
			$this->render('Blocks.edit');

			return;
		}
		// ブロックが存在する場合
		else {
			// 回覧板情報を取得
			$circularNoticeFrameSetting = $this->CircularNoticeFrameSetting->getCircularNoticeFrameSetting($this->viewVars['frameKey']);
			$circularNotice = $this->CircularNotice->getCircularNotice($this->viewVars['blockId']);

			// ログインユーザIDを取得
			$userId =(int)$this->Auth->user('id');

			// モデルに渡すため、権限関連の値を配列に詰めなおす
			$permission = array(
				'contentPublishable' => (int)$this->viewVars['contentPublishable'],	// 公開権限
				'contentEditable' => (int)$this->viewVars['contentEditable'],		// 編集権限
				'contentCreatable' => (int)$this->viewVars['contentCreatable'],		// 作成権限
				'contentReadable' => (int)$this->viewVars['contentReadable'],		// 参照権限
			);

			// 回覧一覧取得
			$circularNoticeContentList = $this->CircularNoticeContent->getCircularNoticeContentList($circularNotice['CircularNotice']['key'], $userId, $permission);

			// 画面表示のためのデータを設定
			$circularNoticeFrameSetting = $this->camelizeKeyRecursive($circularNoticeFrameSetting);
			$this->set('circularNoticeFrameSetting', $circularNoticeFrameSetting['circularNoticeFrameSetting']);
			$circularNotice = $this->camelizeKeyRecursive($circularNotice);
			$this->set('circularNotice', $circularNotice['circularNotice']);
			$circularNoticeContentList = $this->camelizeKeyRecursive($circularNoticeContentList);
			$this->set('circularNoticeContentList', $circularNoticeContentList);
		}
	}

/**
 * __getGroupId method
 *
 * @param int $roomId roles_rooms_users.user_id
 * @return array
 */
	private function __getGroupId($roomId) {
		return array(
			"10" => "テストグループ10",
			"11" => "テストグループ11",
			"12" => "テストグループ12",
		);
	}
}
