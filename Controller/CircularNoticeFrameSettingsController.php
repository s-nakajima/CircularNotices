<?php
/**
 * CircularNoticeFrameSettingsController. Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CircularNoticesAppController', 'CircularNotices.Controller');

/**
 * CircularNoticeFrameSettingsController. Controller
 *
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @package NetCommons\CircularNotices\Controller
 */
class CircularNoticeFrameSettingsController extends CircularNoticesAppController {

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
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsWorkflow',
		'NetCommons.NetCommonsRoomRole' => array(
			// コンテンツの権限設定
			'allowedActions' => array(
				'blockEditable' => array('index', 'add', 'edit', 'delete')
			),
		),
	);

	/**
	 * use helpers
	 *
	 * @var array
	 */
	public $helpers = array(
		'NetCommons.Token',
	);

	/**
	 * beforeFilter
	 *
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('index');

		$results = $this->camelizeKeyRecursive($this->NetCommonsFrame->data);
		$this->set($results);
	}

	/**
	 * edit
	 *
	 * @return void
	 */
	public function edit() {
		$this->__initCircularNoticeFrameSetting();

		// 設定保存時
		if ($this->request->isPost()) {
			$data = $this->data;
			$this->CircularNoticeFrameSetting->saveCircularNoticeFrameSetting($data);

//			if ($this->handleValidationError($this->BbsFrameSetting->validationErrors)) {
//				if (! $this->request->is('ajax')) {
//					$this->redirect('/bbses/bbses/index/' . $this->viewVars['frameId']);
//				}
//				return;
//			}

			$results = $this->camelizeKeyRecursive($data);
			$this->set($results);
		}
	}

	/**
	 * __initCircularNoticeFrameSetting
	 *
	 * @return void
	 */
	private function __initCircularNoticeFrameSetting() {
		if (! $circularNoticeFrameSetting = $this->CircularNoticeFrameSetting->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'frame_key' => $this->viewVars['frameKey']
			)
		))) {
			$circularNoticeFrameSetting = $this->BbsFrameSetting->create(
				array(
					'frame_key' => $this->viewVars['frameKey']
				)
			);
		}
		$circularNoticeFrameSetting = $this->camelizeKeyRecursive($circularNoticeFrameSetting);
		$this->set($circularNoticeFrameSetting);
	}
}
