<?php
/**
 * View/Elements/CircularNotices/status_labelのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');
App::uses('CircularNoticeComponent', 'CircularNotices.Controller/Component');

/**
 * View/Elements/CircularNotices/status_labelのテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\View\Elements\CircularNotices\StatusLabel
 */
class CircularNoticesViewElementsCircularNoticesStatusLabelTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'circular_notices';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'CircularNotices', 'TestCircularNotices');
		//テストコントローラ生成
		$this->generateNc('TestCircularNotices.TestViewElementsCircularNoticesStatusLabel');
	}

/**
 * View/Elements/CircularNotices/status_labelのテスト用DataProvider
 *
 * @return array
 */
	public function dataProviderStatusLabel() {
		$results = array();

		$results[0] = array(
			'CircularNoticeContent' => array(
				'content_status' => 1,
			)
		);
		$results[1] = array(
			'CircularNoticeContent' => array(
				'content_status' => 6,
				'reply_status' => 1
			)
		);

		return $results;
	}

/**
 * View/Elements/CircularNotices/status_labelのテスト
 *
 * @param $data
 * @return void
 * @dataProvider dataProviderStatusLabel
 */
	public function testStatusLabel($data) {
		$this->controller->set('circularNoticeContent', $data);

		//テスト実行
		$this->_testGetAction('/test_circular_notices/test_view_elements_circular_notices_status_label/status_label',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/CircularNotices/status_label', '/') . '/';
		$this->assertRegExp($pattern, $this->view);
	}

}
