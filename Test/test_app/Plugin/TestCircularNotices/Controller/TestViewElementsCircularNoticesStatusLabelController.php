<?php
/**
 * View/Elements/CircularNotices/status_labelテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * View/Elements/CircularNotices/status_labelテスト用Controller
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\test_app\Plugin\TestCircularNotices\Controller
 */
class TestViewElementsCircularNoticesStatusLabelController extends AppController {

/**
 * status_label
 *
 * @return void
 */
	public function status_label() {
		$this->autoRender = true;
	}

}
