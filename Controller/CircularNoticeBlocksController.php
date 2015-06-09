<?php
/**
 * CircularNoticeBlocks Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CircularNoticesAppController', 'CircularNotices.Controller');

/**
 * CircularNoticeBlocks Controller
 *
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @package NetCommons\CircularNotices\Controller
 */
class CircularNoticeBlocksController extends CircularNoticesAppController {

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'Frames.Frame',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'blockEditable' => array('index')
			),
		),
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
	}

/**
 * index
 *
 * @return void
 */
	public function index() {

		if (! $this->NetCommonsFrame->validateFrameId()) {
			$this->throwBadRequest();
			return false;
		}

		if (! $frame = $this->Frame->findById($this->viewVars['frameId'])) {
			$this->throwBadRequest();
			return false;
		}

		if (! $frame['Block'] || ! $frame['Block']['id']) {
			$this->throwBadRequest();
			return false;
		}

		// ブロック一覧の表示がないため、権限設定画面へ直接遷移
		$this->redirect('/circular_notices/circular_notice_block_role_permissions/edit/' . $this->viewVars['frameId'] . '/' . $frame['Block']['id']);
	}
}
