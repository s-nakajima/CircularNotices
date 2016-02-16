<?php
/**
 * CircularNoticeBlockRolePermissions Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CircularNoticesAppController', 'CircularNotices.Controller');

/**
 * CircularNoticeBlockRolePermissions Controller
 *
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @package NetCommons\CircularNotices\Controller
 */
class CircularNoticeBlockRolePermissionsController extends CircularNoticesAppController {

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
		'Blocks.BlockTabs' => array(
			'mainTabs' => array(
//				'block_index' => array('url' => array('controller' => 'circular_notice_blocks')),
//				'circular_notice_setting' => array('url' => array('controller' => 'circular_notice_block_role_permissions', 'action' => 'edit')),
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
		//'NetCommons.Token',
		'Blocks.BlockRolePermissionForm',
		'NetCommons.Date',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('index');

		// タブの設定
		$this->initSettingTabs('role_permissions');
	}

/**
 * edit action
 *
 * @return void
 */
	public function edit() {

		$permissions = $this->Workflow->getBlockRolePermissions(
			array('content_creatable', 'content_publishable', /*'content_comment_creatable', *//*'content_comment_publishable'*/)
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

		//$permissions = $this->NetCommonsBlock->getBlockRolePermissions(
		//	$this->viewVars['blockKey'],
		//	['content_creatable']
		//);

		if (! $setting = $this->CircularNoticeSetting->getCircularNoticeSetting($frameId)) {
			$this->throwBadRequest();
			return false;
		}

		if ($this->request->is(array('post', 'put'))) {
			$data = $this->data;
			$this->CircularNoticeSetting->saveCircularNoticeSetting($data);
			if ($this->handleValidationError($this->CircularNoticeSetting->validationErrors)) {
				if (! $this->request->is('ajax')) {
					$this->redirectByFrameId();
				}
				return;
			}
		} else {
			$this->request->data['circularNoticeSetting'] = $setting['CircularNoticeSetting'];
			$this->request->data['BlockRolePermission'] = $permissions['BlockRolePermissions'];
			$this->request->data['Frame'] = Current::read('Frame');
		}

		//$results = array(
		//	'circularNoticeSetting' => $setting['CircularNoticeSetting'],
		//	'blockRolePermissions' => $permissions['BlockRolePermissions'],
		//	'roles' => $permissions['Roles'],
		//);
		//$results = $this->camelizeKeyRecursive($results);
		//$this->set($results);
	}
}
