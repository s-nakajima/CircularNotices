<?php
/**
 * CircularNotices App Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * CircularNotices App Controller
 *
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @package NetCommons\CircularNotices\Controller
 */
class CircularNoticesAppController extends AppController {

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'CircularNotices.CircularNoticeFrameSetting',
		'CircularNotices.CircularNoticeSetting',
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsBlock',
		'Pages.PageLayout',
		'Security',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		$results = $this->camelizeKeyRecursive(['current' => $this->current]);
		$this->set($results);
	}

/**
 * Initialize circular notices
 *
 * @return void
 */
	public function initCircularNotice() {

		// ブロック設定を取得
		$circularNoticeSetting = $this->CircularNoticeSetting->getCircularNoticeSetting($this->viewVars['frameId']);
		if (! $circularNoticeSetting) {
			$this->throwBadRequest();
			return;
		}
		$circularNoticeSetting = $this->camelizeKeyRecursive($circularNoticeSetting);
		$this->set($circularNoticeSetting);

		// フレーム設定を取得
		$circularNoticeFrameSetting = $this->CircularNoticeFrameSetting->getCircularNoticeFrameSetting($this->viewVars['frameKey']);
		if (! $circularNoticeFrameSetting) {
			$this->throwBadRequest();
			return;
		}
		$circularNoticeFrameSetting = $this->camelizeKeyRecursive($circularNoticeFrameSetting);
		$this->set($circularNoticeFrameSetting);
	}

/**
 * Initialize setting tabs
 *
 * @param string $activeTab
 * @return void
 */
	public function initSettingTabs($activeTab) {

		$blockId = null;
		if (isset($this->params['pass'][1])) {
			$blockId = (int)$this->params['pass'][1];
		} elseif (isset($this->viewVars['blockId'])) {
			$blockId = $this->viewVars['blockId'];
		}

		$settingTabs = array(
			'tabs' => array(
				'circular_notice_settings' => array(
					'url' => array(
						'plugin' => $this->params['plugin'],
						'controller' => 'circular_notice_settings',
						'action' => 'edit',
						$this->viewVars['frameId'],
						$blockId,
					),
					'label' => __d('circular_notices', 'Privilege Setting'),
				),
				'circular_notice_frame_settings' => array(
					'url' => array(
						'plugin' => $this->params['plugin'],
						'controller' => 'circular_notice_frame_settings',
						'action' => 'edit',
						$this->viewVars['frameId'],
					),
					'label' => __d('net_commons', 'Frame settings'),
				),
			),
			'active' => $activeTab,
		);
		$this->set('settingTabs', $settingTabs);
	}

// FIXME: スタブメソッド
	protected function getGroupsStub() {
		return array(
			array('Group' => array(
				'id' => 1,
				'name' => 'スタブグループ01'
			)),
			array('Group' => array(
				'id' => 2,
				'name' => 'スタブグループ02'
			)),
			array('Group' => array(
				'id' => 3,
				'name' => 'スタブグループ03'
			)),
			array('Group' => array(
				'id' => 4,
				'name' => 'スタブグループ04'
			)),
			array('Group' => array(
				'id' => 5,
				'name' => 'スタブグループ05'
			)),
		);
	}
}
