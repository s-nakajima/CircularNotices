<?php
/**
 * CircularNoticeMailSettings Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CircularNoticesAppController', 'CircularNotices.Controller');

/**
 * CircularNoticeMailSettings Controller
 *
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @package NetCommons\CircularNotices\Controller
 */
class CircularNoticeMailSettingsController extends CircularNoticesAppController {

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
				'role_permissions' => array('url' => array('controller' => 'circular_notice_block_role_permissions')),
				'frame_settings' => array('url' => array('controller' => 'circular_notice_frame_settings')),
				'mail_settings' => array('url' => array('controller' => 'circular_notice_mail_settings')),
			),
		),
		'NetCommons.Permission' => array(
			//アクセスの権限
			'allow' => array(
				'edit' => 'page_editable',
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
		'NetCommons.DisplayNumber',
		'Blocks.BlockRolePermissionForm',
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
 * edit action
 *
 * @return void
 */
	public function edit() {
		$permissions = $this->Workflow->getBlockRolePermissions(
			array('content_creatable', 'content_publishable')
		);
		$this->set('roles', $permissions['Roles']);

		$frameId = Current::read('Frame.id');
		if (! $frameId) {
			$this->throwBadRequest();
			return false;
		}

		if (! $frame = $this->Frame->findById($frameId)) {
			$this->throwBadRequest();
			return false;
		}

		if (! $frame['Block'] || ! $frame['Block']['id']) {
			$this->throwBadRequest();
			return false;
		}
		$this->set('blockId', $frame['Block']['id']);
		$this->set('blockKey', $frame['Block']['key']);

		if (! $setting = $this->CircularNoticeSetting->getCircularNoticeSetting($frameId)) {
			$this->throwBadRequest();
			return false;
		}

		if ($this->request->is(array('post', 'put'))) {
			// TODO メール設定処理
		} else {
			$this->request->data['CircularNoticeSetting'] = $setting['CircularNoticeSetting'];
			$this->request->data['BlockRolePermission'] = $permissions['BlockRolePermissions'];
			$this->request->data['Frame'] = Current::read('Frame');
		}
	}
}
