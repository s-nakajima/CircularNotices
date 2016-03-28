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
	public $fixtures = array(
			'plugin.circular_notices.circular_notice_choice',
			'plugin.circular_notices.circular_notice_content',
			'plugin.circular_notices.circular_notice_frame_setting',
			'plugin.circular_notices.circular_notice_setting',
			'plugin.circular_notices.circular_notice_target_user',
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
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
	}

	/**
	 * POSTリクエストデータ生成
	 *
	 * @return array リクエストデータ
	 */
	private function __data() {
		$data = array(
				'Frame' => array(
						'id' => 5,
						'key' => 'frame_1'
				),
				'Block' => array(
						'id' => 5,
						'key' => 'block_1'
				),
				'CircularNoticeSetting' => array(
						'id' => 6,
						'frame_key' => 'frame_2',
						'display_number' => '10',
				),
				'CircularNoticeFrameSetting' => array(
						'id' => 6,
						'frame_key' => 'frame_2',
						'display_number' => '10',
				),
		);
		return $data;
	}

	/**
	 * edit()アクションのGetリクエストテスト
	 *
	 * @param array $urlOptions URLオプション
	 * @param array $assert テストの期待値
	 * @param string|null $exception Exception
	 * @param string $return testActionの実行後の結果
	 * @dataProvider dataProviderEditGet
	 * @return void
	 */
	public function testEditGet($urlOptions, $assert, $exception = null, $return = 'view') {

		// Exception
		if ($exception) {
			$this->setExpectedException($exception);
		}

		// テスト実施
		$url = Hash::merge(array(
				'plugin' => $this->plugin,
				'controller' => 'circular_notices_app',
				'action' => 'initCircularNotice',
		), $urlOptions);

		$this->_testGetAction($url, $assert, $exception, $return);

		//チェック
		//TODO:assert追加
	}

	/**
	 * editアクションのGETテスト(ログインなし)用DataProvider
	 *
	 * #### 戻り値
	 *  - urlOptions: URLオプション
	 *  - assert: テストの期待値
	 *  - exception: Exception
	 *  - return: testActionの実行後の結果
	 *
	 * @return array
	 */
	public function dataProviderEditGet() {
		$data = $this->__data();
		$results = array();

		//ログインなし
		$results[0] = array(
				'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id']),
				'assert' => null, 'exception' => 'ForbiddenException'
		);
		return $results;
	}

	/**
	 * editアクションのGETテスト
	 *
	 * @param array $urlOptions URLオプション
	 * @param array $assert テストの期待値
	 * @param string|null $exception Exception
	 * @param string $return testActionの実行後の結果
	 * @dataProvider dataProviderEditGetByPublishable
	 * @return void
	 */
	public function testEditGetByPublishable($urlOptions, $assert, $exception = null, $return = 'view') {
		// Exception
		if ($exception) {
			$this->setExpectedException($exception);
		}
		//ログイン
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR);

		//テスト実施
		$url = Hash::merge(array(
				'plugin' => $this->plugin,
				'controller' => 'circular_notices_app',
				'action' => 'initCircularNotice',
		), $urlOptions);

		$this->_testGetAction($url, $assert, $exception, $return);

		//ログアウト
		TestAuthGeneral::logout($this);

		//チェック
		//TODO:assert追加
	}

	/**
	 * editアクションのGETテスト(ログインあり)用DataProvider
	 *
	 * #### 戻り値
	 *  - urlOptions: URLオプション
	 *  - assert: テストの期待値
	 *  - exception: Exception
	 *  - return: testActionの実行後の結果
	 *
	 * @return array
	 */
	public function dataProviderEditGetByPublishable() {
		$data0 = $this->__data();
		$results = array();

		//ログインあり
		$results[0] = array(
				'urlOptions' => array('frame_id' => $data0['Frame']['id'], 'block_id' => $data0['Block']['id'], 'key' => $data0['CircularNoticeFrameSetting']['id']),
				'assert' => null
		);

		return $results;
	}
	
	/**
	 * editアクションのExceptionテスト
	 *
	 * @param array $urlOptions URLオプション
	 * @param array $assert テストの期待値
	 * @param string|null $exception Exception
	 * @param string $return testActionの実行後の結果
	 * @dataProvider dataProviderEditGetByPublishable
	 * @return void
	 */
	public function testEditGetExceptionByPublishable($urlOptions, $assert, $exception = null, $return = 'view') {
		// Exception
		if ($exception) {
			$this->setExpectedException($exception);
		}
		//ログイン
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR);

		//テスト実施
		$url = Hash::merge(array(
				'plugin' => $this->plugin,
				'controller' => 'circular_notices_app',
				'action' => 'initCircularNotice',
		), $urlOptions);

		$this->_testGetAction($url, $assert, $exception, $return);

		//ログアウト
		TestAuthGeneral::logout($this);

		//チェック
		//TODO:assert追加
	}

	/**
	 * editアクションのGETテスト(ログインあり)用DataProvider
	 *
	 * #### 戻り値
	 *  - urlOptions: URLオプション
	 *  - assert: テストの期待値
	 *  - exception: Exception
	 *  - return: testActionの実行後の結果
	 *
	 * @return array
	 */
	public function dataProviderEditGetExceptionByPublishable() {
		$data0 = $this->__data();
		$results = array();

		//ログインあり
		$results[0] = array(
				'urlOptions' => array('frame_id' => $data0['Frame']['id'], 'block_id' => $data0['Block']['id'], 'key' => null),
				'assert' => null, 'exception' => 'ForbiddenException'
		);

		return $results;
	}
	
}
