<?php
/**
 * CircularNoticeFrameSettings Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CircularNoticesAppController', 'CircularNotices.Controller');

/**
 * CircularNoticeFrameSettings Controller
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
		'Blocks.Block',
		'Frames.Frame',
//		'CircularNotices.CircularNotice',
		'CircularNotices.CircularNoticeFrameSetting',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'Blocks.BlockTabs' => array(
			'mainTabs' => array(
				'block_index' => array('url' => array('controller' => 'circular_notice_blocks')),
				'role_permissions' => array('url' => array('controller' => 'circular_notice_block_role_permissions')),
				'frame_settings' => array('url' => array('controller' => 'circular_notice_frame_settings')),
			),
		),
		'NetCommons.Permission' => array(
			//アクセスの権限
			'allow' => array(
				'edit' => 'block_permission_editable',
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

		// タブの設定
		$this->initSettingTabs('circular_notice_frame_settings');
	}

/**
 * edit action
 *
 * @return void
 */
	public function edit() {
		if (! $this->NetCommonsFrame->validateFrameId()) {
			$this->throwBadRequest();
			return false;
		}

		if (! $frameSetting = $this->CircularNoticeFrameSetting->getCircularNoticeFrameSetting($this->viewVars['frameKey'])) {
			$frameSetting = $this->CircularNoticeFrameSetting->create(array(
				'frame_key' => $this->viewVars['frameKey'],
			));
		}

		$data = array();
		if ($this->request->is(array('post', 'put'))) {
			$data = $this->data;
			$this->CircularNoticeFrameSetting->saveCircularNoticeFrameSetting($data);
			if ($this->handleValidationError($this->CircularNoticeFrameSetting->validationErrors)) {
				$this->redirectByFrameId();
				return;
			}
		}

		$data = Hash::merge(
			$frameSetting,
			$data
		);
		$results = $this->camelizeKeyRecursive($data);
		$this->set($results);
	}
}
