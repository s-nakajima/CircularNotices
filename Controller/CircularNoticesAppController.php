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
App::uses('CircularNoticeComponent', 'CircularNotices.Controller/Component');

/**
 * CircularNotices App Controller
 *
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @package NetCommons\CircularNotices\Controller
 */
class CircularNoticesAppController extends AppController {

/**
 * @var array 回覧板名
 */
	protected $_circularNoticeTitle;

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
		'Pages.PageLayout',
		'Security',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Date',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		$results = $this->current;
		$this->set($results);

		// フレームが新規配置された場合はブロック設定／フレーム設定を初期化
		$blockId = Current::read('Block.id');
		if (! $blockId) {
			$frameId = Current::read('Frame.id');
			$this->CircularNoticeSetting->setCircularNoticeSetting($frameId);
			$this->CircularNoticeFrameSetting->setCircularNoticeFrameSetting($frameId);
		}
	}
}
