<?php
/**
 * CircularNoticeComponent::setCircularNoticeErrors()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * CircularNoticeComponent::setCircularNoticeErrors()のテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Controller\Component\CircularNoticeComponent
 */
class CircularNoticeComponentSetCircularNoticeErrorsTest extends NetCommonsControllerTestCase {

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
 * getDisplayDateFormat()のテスト
 *
 * @return void
 */
	public function testSetCircularNoticeErrors() {
		//テストコントローラ生成
		$this->generateNc('TestCircularNotices.TestCircularNoticeComponent');

		//ログイン
		TestAuthGeneral::login($this);

		$this->controller->Session->expects($this->any())
			->method('read')
			->will($this->returnValueMap([['circularNoticeErrors', ['CircularNoticeTargetUser' => 'Validation error']]]));

		//テストアクション実行
		$this->_testGetAction('/test_circular_notices/test_circular_notice_component/index',
				array('method' => 'assertNotEmpty'), null, 'view');
		$pattern = '/' . preg_quote('Controller/Component/TestCircularNoticeComponent', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		//テスト実行
		$result = $this->controller->CircularNotice->setCircularNoticeErrors($this->controller);

		//チェック
		$this->assertEquals($result, null);
	}

}
