<?php
/**
 * CircularNoticesController::download()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');
App::uses('NetCommonsComponent', 'NetCommons.Controller/Component');

/**
 * CircularNoticesController::download()のテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Controller\CircularNoticesController
 */
class CircularNoticesControllerDownloadTest extends NetCommonsControllerTestCase {

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
		'plugin.user_attributes.user_attribute_layout',
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
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'circular_notices';

/**
 * テストDataの取得
 *
 * @return array
 */
	private function __getData() {
		$frameId = '6';
		$blockId = '2';
		$contentKey = 'circular_notice_content_1';

		$data = array(
			'frame_id' => $frameId,
			'block_id' => $blockId,
			'key' => $contentKey,
		);

		return $data;
	}

/**
 * テストDataの取得
 *
 * @return array
 */
	private function __getRequestData() {
		return array(
			'success' => array(
				'AuthorizationKey' => array(
					'authorization_key' => 'netcommons'
				)
			),
			'empty' => array(
				'AuthorizationKey' => array(
					'authorization_key' => ''
				)
			),
		);
	}

/**
 * downloadアクションのテスト(作成権限のみ)用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderDownload() {
		$data = $this->__getData();
		$requestData = $this->__getRequestData();

		//テストデータ
		$results = array();

		$results[0] = array(
			'urlOptions' => Hash::insert($data, 'frame_id', ''),
			'data' => $requestData['success'],
			'assert' => null,
		);
		$results[1] = array(
			'urlOptions' => Hash::insert($data, 'key', 'circular_notice_content_1'),
			'data' => $requestData['success'],
			'assert' => null,
		);
		$results[2] = array(
			'urlOptions' => Hash::insert($data, 'key', 'circular_notice_content_2'),
			'data' => $requestData['success'],
			'assert' => null,
		);
		$results[3] = array(
			'urlOptions' => Hash::insert($data, 'key', 'circular_notice_content_3'),
			'data' => $requestData['success'],
			'assert' => null,
		);
		$results[4] = array(
			'urlOptions' => Hash::insert($data, 'key', 'circular_notice_content_4'),
			'data' => $requestData['success'],
			'assert' => null,
		);

		return $results;
	}

/**
 * downloadのDataProviderExceptionError
 *
 * ### 戻り値
 *  - method: リクエストメソッド（get or post or put）
 *  - data: 登録データ
 * -  urlOptions: URLオプション
 * -  assert: テストの期待値
 * -  exception: Exception
 * -  return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderDownloadExceptionError() {
		$data = $this->__getData();
		$requestData = $this->__getRequestData();

		$results = array();
		$results[0] = array(
			'urlOptions' => Hash::insert($data, 'key', '9999'),
			'data' => $requestData['success'],
			'assert' => null,
		);
		$results[1] = array(
			'urlOptions' => Hash::insert($data, 'frame_id', ''),
			'data' => $requestData['empty'],
			'assert' => null,
		);

		return $results;
	}

/**
 * downloadアクションのテスト(作成権限のみ)
 *
 * @param array $urlOptions URLオプション
 * @param array $data リクエストパラメータ
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderDownload
 * @return void
 */
	public function testDownload($urlOptions, $data, $assert, $exception = null, $return = 'view') {
		//ログイン
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_GENERAL_USER);

		//テスト実施
		$this->controller->request->params = Hash::merge(
			$this->controller->request->params,
			$urlOptions
		);
		$this->controller->request->params['key'] = $urlOptions['key'];
		$this->controller->request->data = $data;
		Current::initialize($this->controller);
		$id = empty($urlOptions['frame_id']) ? '6' : $urlOptions['frame_id'];
		Current::write('Frame', [
			'id' => $id,
			'key' => $urlOptions['key'],
		]);
		$response = $this->controller->download();
		$this->assertInstanceOf('CakeResponse', $response);
		$this->assertEquals('application/zip', $response->type());
		$this->assertEquals($assert, $response->body());

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 *
 * downloadのテスト(ExceptionError)
 *
 * @param array $urlOptions URLオプション
 * @param array $data リクエストパラメータ
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderDownloadExceptionError
 * @return void
 */
	public function testDownloadExceptionError($urlOptions, $data, $assert, $exception = null, $return = 'view') {
		//ログイン
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_GENERAL_USER);

		//テスト実施
		ob_start();
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'download',
		), $urlOptions);
		$this->_testPostAction('post', $data, $url, $exception, $return);

		//チェック
		$this->asserts($assert, $this->contents);
		ob_end_clean();

		//ログアウト
		TestAuthGeneral::logout($this);
	}
}
