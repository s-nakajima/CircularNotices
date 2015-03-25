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
	}

/**
 * view method
 *
 * @param int $frameId frames.id
 * @param int $circularNoticeContentId circular_notice_content.id
 * @return void
 */
	public function view($frameId, $circularNoticeContentId) {


	}

/**
 * edit method
 *
 * @param int $frameId frames.id
 * @param int $circularNoticeContentId circular_notice_content.id
 * @return void
 */
	public function edit($frameId, $circularNoticeContentId = null) {
		$result = null;

		// 編集の場合
		if($circularNoticeContentId) {
			$result = $this->CircularNoticeContent->getCircularNoticeContent($circularNoticeContentId);
//			print_r($result);
		}
		// 新規登録の場合
		else {
			$result = $this->CircularNoticeContent->create();
//			print_r($result);
			// 初期値を設定する
			// $result['CircularNoticeContent']['content'] = '';
			// $result['CircularNoticeContent']['reply_type'] = (int)CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT;
//			$result['contentStatus'] = $result['CircularNoticeContent']['status'];
		}

		//グループ情報を取得（Todo: 共通待ち)
		$groups = null;
		$groups['Group'][0] = array('id' => 10, 'group_name' => 'テストグループ10', );
		$groups['Group'][1] = array('id' => 11, 'group_name' => 'テストグループ11', );
		$groups['Group'][2] = array('id' => 12, 'group_name' => 'テストグループ12', );

		// 回答方式の定数配列を格納
		$result['CircularNoticeContent']['circularNoticeContentReplyType'] = array(
			'typeText' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT,
			'typeSelection' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION,
			'typeMultipleSelection' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION,
		);


		// 画面表示のためのデータを設定
		$result = $this->camelizeKeyRecursive($result);
//		$this->set('circularNoticeContent', $result['circularNoticeContent']);
		$this->set('circularNoticeContent', $result['circularNoticeContent']);
		$this->set('contentStatus', $result['circularNoticeContent']['status']);

		$groups = $this->camelizeKeyRecursive($groups);
		$this->set('groups', $groups['group']);

		// $circularNoticeContentReplyType = $this->camelizeKeyRecursive($circularNoticeContentReplyType));
		// $this->set('circularNoticeContentReplyType', $circularNoticeContentReplyType);

		// print_r($result);
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
