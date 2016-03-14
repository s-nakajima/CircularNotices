<?php
/**
 * CircularNoticeFrameSettingsController::edit()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * CircularNoticeFrameSettingsController::edit()のテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Controller\CircularNoticeFrameSettingsController
 */
class CircularNoticeFrameSettingsControllerEditTest extends NetCommonsControllerTestCase {

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
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'circular_notice_frame_settings';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

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
 * edit()アクションのGetリクエストテスト
 *
 * @return void
 */
	public function testEditGet() {
		//テストデータ
		$frameId = '6';
		$blockId = '2';
		$blockKey = 'block_1';

		//テスト実行
		$this->_testGetAction(array('action' => 'edit', 'block_id' => $blockId, 'frame_id' => $frameId),
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->__assertEditGet($frameId, $blockId, $blockKey);
	}

/**
 * edit()のチェック
 *
 * @param int $frameId フレームID
 * @param int $blockId ブロックID
 * @param string $blockKey ブロックKey
 * @return void
 */
	private function __assertEditGet($frameId, $blockId, $blockKey) {
		//TODO:必要に応じてassert書く
		debug($this->view);
		debug($this->controller->request->data);

		$this->assertInput('form', null, 'circular_notices/circular_notice_frame_settings/edit/' . $blockId, $this->view);
		$this->assertInput('input', '_method', 'PUT', $this->view);
		$this->assertInput('input', 'data[Frame][id]', $frameId, $this->view);
		$this->assertInput('input', 'data[Block][id]', $blockId, $this->view);
		$this->assertInput('input', 'data[Block][key]', $blockKey, $this->view);

		$this->assertEquals($frameId, Hash::get($this->controller->request->data, 'Frame.id'));
		$this->assertEquals($blockId, Hash::get($this->controller->request->data, 'Block.id'));
		$this->assertEquals($blockKey, Hash::get($this->controller->request->data, 'Block.key'));

		//TODO:必要に応じてassert書く
	}

/**
 * POSTリクエストデータ生成
 *
 * @return array リクエストデータ
 */
	private function __data() {
		$data = array(
			'Frame' => array(
				'id' => '6'
			),
			'Block' => array(
				'id' => '2', 'key' => 'block_1'
			),
			//TODO:必要に応じて、assertを追加する
		);

		return $data;
	}

/**
 * edit()アクションのPOSTリクエストテスト
 *
 * @return void
 */
	public function testEditPost() {
		//テストデータ
		$frameId = '6';
		$blockId = '2';

		//テスト実行
		$this->_testPostAction('put', $this->__data(),
				array('action' => 'edit', 'block_id' => $blockId, 'frame_id' => $frameId), null, 'view');

		//チェック
		$header = $this->controller->response->header();
		$pattern = '/' . preg_quote('/circular_notice/circular_notice/index/' . $blockId, '/') . '/';
		$this->assertRegExp($pattern, $header['Location']);
	}

/**
 * ValidationErrorテスト
 *
 * @return void
 */
	public function testEditPostValidationError() {
		$this->_mockForReturnFalse('TODO:MockにするModel名書く', 'TODO:Mockにするメソッド名書く');

		//テストデータ
		$frameId = '6';
		$blockId = '2';

		//テスト実行
		//TODO:処理によって必要な方を有効にする
		$this->_testPostAction('put', $this->__data(),
				array('action' => 'edit', 'block_id' => $blockId, 'frame_id' => $frameId), null, 'view');
		//$this->_testPostAction('put', $this->__data(),
		//		array('action' => 'edit', 'block_id' => $blockId, 'frame_id' => $frameId), 'BadRequestException', 'view');

		//TODO:必要に応じてassert書く
	}

}
