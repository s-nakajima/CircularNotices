<?php
/**
 * CircularNoticeComponent::initCircularNotice()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');
App::uses('WorkflowComponent', 'Workflow.Controller/Component');
App::uses('WorkflowBehavior', 'Workflow.Model/Behavior');

/**
 * CircularNoticeComponent::initCircularNotice()のテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Controller\Component\CircularNoticeComponent
 */
class CircularNoticeComponentInitCircularNoticeTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.circular_notices.circular_notice_frame_setting',
		'plugin.circular_notices.circular_notice_setting',
		'plugin.frames.frame',
		'plugin.blocks.block',
	);

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
 * initCircularNoticeのテスト用DataProvider
 *
 * ### 戻り値
 *  - userId: ユーザID
 *  - frameId: フレームID
 *  - frameKey: フレームキー
 *  - action: アクション名
 *  - assert: テストの期待値
 *
 * @return array
 */
	public function dataProvider() {
		return array(
			array(
				'userId' => '',
				'frameId' => '',
				'frameKey' => '',
				'action' => 'index',
				'assert' => false,
			),
			array(
				'userId' => '1',
				'frameId' => '',
				'frameKey' => '',
				'action' => 'index',
				'assert' => false,
			),
			array(
				'userId' => '1',
				'frameId' => '6',
				'frameKey' => 'frame_1',
				'action' => 'index',
				'assert' => true,
			),
			array(
				'userId' => '1',
				'frameId' => '6',
				'frameKey' => '',
				'action' => 'index',
				'assert' => false,
			),
			array(
				'userId' => '',
				'frameId' => '',
				'frameKey' => '',
				'action' => 'view',
				'assert' => false,
			),
			array(
				'userId' => '1',
				'frameId' => '',
				'frameKey' => '',
				'action' => 'view',
				'assert' => false,
			),
			array(
				'userId' => '1',
				'frameId' => '6',
				'frameKey' => 'frame_1',
				'action' => 'view',
				'assert' => true,
			),
			array(
				'userId' => '1',
				'frameId' => '6',
				'frameKey' => '',
				'action' => 'view',
				'assert' => false,
			),
		);
	}

/**
 * initCircularNotice()のテスト
 *
 * @param $userId
 * @param $frameId
 * @param $frameKey
 * @param $action
 * @param $assert
 * @dataProvider dataProvider
 * @return void
 */
	public function testInitCircularNotice($userId, $frameId, $frameKey, $action, $assert = null) {
		//テストコントローラ生成
		$this->generateNc('TestCircularNotices.TestCircularNoticeComponent');

		//ログイン
		TestAuthGeneral::login($this);

		Current::write('User.id', $userId);
		Current::write('Frame.id', $frameId);
		Current::write('Frame.key', $frameKey);

		//テストアクション実行
		$this->_testGetAction('/test_circular_notices/test_circular_notice_component/' . $action,
				array('method' => 'assertNotEmpty'), null, 'view');
		$pattern = '/' . preg_quote('Controller/Component/TestCircularNoticeComponent', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		Current::write('User.id', $userId);
		Current::write('Frame.id', $frameId);
		Current::write('Frame.key', $frameKey);

		//テスト実行
		$result = $this->controller->CircularNotice->initCircularNotice($this->controller);

		//チェック
		$this->assertEquals($result, $assert);
	}

}
