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
		$frameId = '5';
		$blockId = '1';
		$contentKey = 'circular_notice_content_1';

		$data = array(
			'frame_id' => $frameId,
			'block_id' => $blockId,
			'key' => $contentKey,
		);

		return $data;
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

		//テストデータ
		$results = array();

		$results[0] = array(
			'urlOptions' => Hash::insert($data, 'frame_id', ''),
			'assert' => null,
		);
		$results[1] = array(
			'urlOptions' => Hash::insert($data, 'key', 'circular_notice_content_1'),
			'assert' => null,
		);
		$results[2] = array(
			'urlOptions' => Hash::insert($data, 'key', 'circular_notice_content_2'),
			'assert' => null,
		);
		$results[3] = array(
			'urlOptions' => Hash::insert($data, 'key', 'circular_notice_content_3'),
			'assert' => null,
		);
		$results[4] = array(
			'urlOptions' => Hash::insert($data, 'key', 'circular_notice_content_4'),
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

		$results = array();
		$results[0] = array(
			'urlOptions' => Hash::insert($data, 'key', '9999'),
			'assert' => null,
		);

		return $results;
	}

/**
 * downloadアクションのテスト(作成権限のみ)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderDownload
 * @return void
 */
	public function testDownload($urlOptions, $assert, $exception = null, $return = 'view') {
		//ログイン
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_GENERAL_USER);

		//テスト実施
		$this->controller->request->params = Hash::merge(
			$this->controller->request->params,
			$urlOptions
		);
		$this->controller->request->params['pass'][1] = $urlOptions['key'];
		Current::initialize($this->controller->request);
		$id = empty($urlOptions['frame_id']) ? '5' : $urlOptions['frame_id'];
		Current::write('Frame', [
			'id' => $id,
			'key' => $urlOptions['key'],
		]);
		$response = $this->controller->download();
		$this->assertInstanceOf('CakeResponse', $response);
		$this->assertEquals('text/csv', $response->type());
		$this->assertEquals($assert, $response->body());

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 *
 * downloadのテスト(ExceptionError)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderDownloadExceptionError
 * @return void
 */
	public function testDownloadExceptionError($urlOptions, $assert, $exception = null, $return = 'view') {
		//ログイン
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_GENERAL_USER);

		//テスト実施
		ob_start();
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'download',
		), $urlOptions);
		$this->_testGetAction($url, $assert, $exception, $return);

		//チェック
		$this->asserts($assert, $this->contents);
		ob_end_clean();

		//ログアウト
		TestAuthGeneral::logout($this);
	}
}