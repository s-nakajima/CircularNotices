<?php
/**
 * CircularNoticeFrameSettingsController Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CircularNoticesAppController', 'CircularNotices.Controller');

/**
 * CircularNoticeFrameSettingsController Controller
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
		'NetCommons.NetCommonsRoomRole' => array(
			// コンテンツの権限設定
			'allowedActions' => array(
				'blockEditable' => array('edit')
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

		$results = $this->camelizeKeyRecursive($this->NetCommonsFrame->data);
		$this->set($results);
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

		if (! $frame = $this->Frame->findById($this->viewVars['frameId'])) {
			$this->throwBadRequest();
			return;
		}

		if (! $block = $this->Block->findById((int)$frame['Frame']['block_id'])) {
			$this->throwBadRequest();
			return false;
		};
		$this->set('blockId', $block['Block']['id']);
		$this->set('blockKey', $block['Block']['key']);

		// タブの設定
		$this->initSettingTabs('circular_notice_frame_settings');

		if (! $circularNoticeFrameSetting = $this->CircularNoticeFrameSetting->getCircularNoticeFrameSetting($this->viewVars['frameKey'])) {
			$circularNoticeFrameSetting = $this->CircularNoticeFrameSetting->create(array(
				'frame_key' => $this->viewVars['frameKey'],
			));
		}

		$data = array();
		if ($this->request->is('post')) {
			$data = $this->data;
			$this->CircularNoticeFrameSetting->saveCircularNoticeFrameSetting($data);
			if ($this->handleValidationError($this->CircularNoticeFrameSetting->validationErrors)) {
				$this->redirectByFrameId();
				return;
			}
		}

		$data = Hash::merge(
			$circularNoticeFrameSetting,
			$data
		);
		$results = $this->camelizeKeyRecursive($data);
		$this->set($results);
	}
}
