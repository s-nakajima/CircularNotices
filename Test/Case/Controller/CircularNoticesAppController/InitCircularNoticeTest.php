<?php
/**
 * CircularNoticesAppController::initCircularNotice()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');
App::uses('UserRole', 'UserRoles.Model');

/**
 * CircularNoticesAppController::initCircularNotice()のテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Controller\CircularNoticesAppController
 */
class CircularNoticesAppControllerInitCircularNoticeTest extends NetCommonsControllerTestCase {

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
		$this->generateNc('TestCircularNotices.TestCircularNoticesAppControllerInitCircularNotice');

		//ログイン
		TestAuthGeneral::login($this);
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
 * initCircularNotice()のテスト
 *
 * @return void
 */
	public function testInitCircularNotice() {
		//TODO:テストデータ

		//テスト実行
		$this->_testGetAction('/test_circular_notices/test_circular_notices_app_controller_init_circular_notice/initCircularNotice', null);

		//チェック
		//TODO:assert追加
		debug($this->view);
	}

}
