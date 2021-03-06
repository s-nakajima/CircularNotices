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
		'Blocks.BlockRolePermissionForm',
		'Blocks.BlockTabs' => array(
			'mainTabs' => array('role_permissions', 'frame_settings', 'mail_settings')
		),
	);

/**
 * edit action
 *
 * @return void
 */
	public function edit() {
		$frameId = Current::read('Frame.id');
		if (!$frameId || !$setting = $this->CircularNoticeSetting->getCircularNoticeSetting($frameId)) {
			$this->setAction('throwBadRequest');
			return false;
		}

		$permissions = $this->Workflow->getBlockRolePermissions(
			array('content_creatable', 'content_publishable')
		);
		$this->set('roles', $permissions['Roles']);

		if ($this->request->is(array('post', 'put'))) {
			$data = $this->data;
			if ($this->CircularNoticeSetting->saveCircularNoticeSetting($data)) {
				$this->redirect(NetCommonsUrl::backToPageUrl(true));
				return;
			}
			$this->NetCommons->handleValidationError($this->CircularNoticeSetting->validationErrors);
			$this->request->data['CircularNoticeRolePermission'] = Hash::merge(
				$permissions['BlockRolePermissions'],
				$this->request->data['BlockRolePermission']
			);
		} else {
			$this->request->data['CircularNoticeSetting'] = $setting['CircularNoticeSetting'];
			$this->request->data['BlockRolePermission'] = $permissions['BlockRolePermissions'];
			$this->request->data['Frame'] = Current::read('Frame');
		}
	}
}
