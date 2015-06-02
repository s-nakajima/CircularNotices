<?php
/**
 * Blocks Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CircularNoticesAppController', 'CircularNotices.Controller');

/**
 * Blocks Controller
 *
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @package NetCommons\CircularNotices\Controller
 */
class BlocksController extends CircularNoticesAppController {

	/**
	 * layout
	 *
	 * @var array
	 */
	public $layout = 'NetCommons.setting';

	/**
	 * use models
	 *
	 * @var array
	 */
	public $uses = array(
		'CircularNotices.CircularNoticeFrameSetting',
		'CircularNotices.CircularNoticeSetting',
		'Blocks.Block',
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
				'blockEditable' => array('index', 'add', 'edit', 'delete')
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

		$results = $this->camelizeKeyRecursive($this->NetCommonsFrame->data);
		$this->set($results);
	}

	/**
	 * index
	 *
	 * @return void
	 */
	public function index() {
		// 一覧は表示しないため、権限設定画面へ遷移
		$this->redirect('/circular_notices/circular_notice_settings/edit/' . $this->viewVars['frameId'] . '/' . $this->viewVars['blockId']);
	}
}
