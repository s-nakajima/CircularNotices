<?php
/**
 * CircularNoticeComponent::getTargetUserHeader()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * CircularNoticeComponent::getTargetUserHeader()のテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Controller\Component\CircularNoticeComponent
 */
class CircularNoticeComponentGetTargetUserHeaderTest extends NetCommonsControllerTestCase {

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
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		//ログアウト
		TestAuthGeneral::logout($this);

		parent::tearDown();
	}

/**
 * getTargetUserHeader()のテスト
 *
 * @return void
 */
	public function testGetTargetUserHeader() {
		//テストコントローラ生成
		$this->generateNc('TestCircularNotices.TestCircularNoticeComponent');

		//ログイン
		TestAuthGeneral::login($this);

		//テストアクション実行
		$this->_testGetAction('/test_circular_notices/test_circular_notice_component/index',
				array('method' => 'assertNotEmpty'), null, 'view');
		$pattern = '/' . preg_quote('Controller/Component/TestCircularNoticeComponent', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		//テスト実行
		$result = $this->controller->CircularNotice->getTargetUserHeader();

		//チェック
		$this->assertNotEmpty($result);
	}

}
