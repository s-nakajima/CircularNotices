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
//		'NetCommons.NetCommonsBlock',
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'contentEditable' => array('indexLatest', 'indexSetting', 'edit', 'delete'),
				'contentCreatable' => array('token', 'edit', 'delete'),
			),
		),
//		'CircularNotice.CircularNotice',
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
		'NetCommons.Date',
	);

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->__initCircularNotice();

		if ($this->request->is('ajax')) {
			$tokenFields = Hash::flatten($this->request->data);
			$hiddenFields = array(
				'CircularNotice.block_id',
				'CircularNotice.key'
			);
			$this->set('tokenFields', $tokenFields);
			$this->set('hiddenFields', $hiddenFields);
			$this->renderJson();
		} else {
//			if ($this->viewVars['contentEditable']) {
//				$this->view = 'Announcements/viewForEditor';
//			}
		}
//print_r($this->viewVars);
	}

/**
 * view method
 *
 * @param int $frameId frames.id
 * @param int $circularNoticeContentId circular_notice_content.id
 * @return void
 */
	public function view($frameId, $circularNoticeContentId) {



		$this->__initCircularNotice();

		if ($this->request->is('ajax')) {
			$tokenFields = Hash::flatten($this->request->data);
			$hiddenFields = array(
				'CircularNotice.block_id',
				'CircularNotice.key'
			);
			$this->set('tokenFields', $tokenFields);
			$this->set('hiddenFields', $hiddenFields);
			$this->renderJson();
		} else {
//			if ($this->viewVars['contentEditable']) {
//				$this->view = 'Announcements/viewForEditor';
//			}
		}
//print_r($this->viewVars);

	}

/**
 * edit method
 *
 * @param int $frameId frames.id
 * @param int $circularNoticeContentId circular_notice_content.id
 * @return void
 */
	public function edit($frameId, $circularNoticeContentId = null) {
		// 編集の場合
		if($circularNoticeContentId) {
			$results = $this->CircularNoticeContent->getCircularNoticeContent($circularNoticeContentId);
			print_r($results);
		}

		// 回答方式選択肢を取得
		$replyType = $this->CircularNoticeChoice->getReplyType();

		$this->set(compact('circularNoticeContentId'));
		$this->set(compact('replyType'));
//		print_r($this->viewVars);

	}

/**
 * __initCircularNotice method
 *
 * @return void
 */
	private function __initCircularNotice() {
		// ブロックが存在しない場合（新規配置）
		if (empty($this->viewVars['blockId'])) {
//			// ブロックを登録
//			$block = $this->Block->saveByFrameId($this->viewVars['frameId'], false);

			// 回覧板の初期設定を実施
			$results = $this->CircularNotice->saveInitialSetting($this->viewVars['frameId'], $this->viewVars['frameKey']);

			// 画面表示のためデータを設定
			$results = $this->camelizeKeyRecursive($results);
			$this->set('circularNoticeFrameSetting', $results['circularNoticeFrameSetting']);
			$this->set('circularNotice', $results['circularNotice']);

			// 設定画面を表示
			$this->render('Blocks/edit');

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

			// 絞り込みのための選択肢取得
			$selectOption = $this->CircularNoticeContent->getSelectOption((int)$this->viewVars['contentCreatable']);
//$this->log(print_r($selectOption, true), 'trace');

			// 画面表示のためのデータを設定
			$circularNoticeFrameSetting = $this->camelizeKeyRecursive($circularNoticeFrameSetting);
			$this->set('circularNoticeFrameSetting', $circularNoticeFrameSetting['circularNoticeFrameSetting']);
			$circularNotice = $this->camelizeKeyRecursive($circularNotice);
			$this->set('circularNotice', $circularNotice['circularNotice']);
			$circularNoticeContentList = $this->camelizeKeyRecursive($circularNoticeContentList);
			$this->set('circularNoticeContentList', $circularNoticeContentList);
			$selectOption = $this->camelizeKeyRecursive($selectOption);
			$this->set('selectOption', $selectOption);
//$this->log(print_r($this->viewVars, true), 'trace');
		}
	}

}
