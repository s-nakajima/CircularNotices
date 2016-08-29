<?php
/**
 * CircularNoticesAnswerController::edit()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * CircularNoticesController::edit()のテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Controller\CircularNoticesController
 */
class CircularNoticesAnswerControllerEditTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.circular_notices.circular_notice_choice',
		'plugin.circular_notices.circular_notice_content',
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
	protected $_controller = 'circular_notices_answer';

/**
 * テストDataの取得
 *
 * @param string $role ロール
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
 * editアクションテスト
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderEdit() {
		$data = $this->__getData();

		//テストデータ
		$results = array();
		$results[0] = array(
			'urlOptions' => Hash::insert($data, 'frame_id', ''),
			'assert' => null,
		);
		$results[1] = array(
			'urlOptions' => Hash::insert($data, 'key', 'A'),
			'assert' => null,
			'exception' => 'BadRequestException'
		);

		return $results;
	}

/**
 * editアクションのテスト
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderEdit
 * @return void
 */
	public function testEdit($urlOptions, $assert, $exception = null, $return = 'view') {
		//ログイン
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR);

		//テスト実施
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'edit',
		), $urlOptions);
		$this->_testGetAction($url, $assert, $exception, $return);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * editアクションテスト
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderEditPost() {
		$data = $this->__getData();
		return array(
			array(
				'urlOptions' => Hash::insert($data, 'key', 'circular_notice_content_1'),
				'data' => array(
					'CircularNoticeContent' => array(
						'key' => 'circular_notice_content_1',
					),
					'CircularNoticeTargetUser' => array(
						'id' => 1,
						'reply_text_value' => '',
					),
				),
				'assert' => array('method' => 'assertEquals'),
			),
			array(
				'urlOptions' => Hash::insert($data, 'key', 'circular_notice_content_1'),
				'data' => array(
					'CircularNoticeContent' => array(
						'key' => 'circular_notice_content_1',
					),
					'CircularNoticeTargetUser' => array(
						'id' => 1,
						'reply_text_value' => 'Lorem ipsum dolor sit amet',
					),
				),
				'assert' => array('method' => 'assertEquals'),
			),
			array(
				'urlOptions' => Hash::insert($data, 'key', 'circular_notice_content_2'),
				'data' => array(
					'CircularNoticeContent' => array(
						'key' => 'circular_notice_content_2',
					),
					'CircularNoticeTargetUser' => array(
						'id' => 2,
						'reply_selection_value' => '2',
					),
				),
				'assert' => array('method' => 'assertEquals'),
			),
			array(
				'urlOptions' => Hash::insert($data, 'key', 'circular_notice_content_3'),
				'data' => array(
					'CircularNoticeContent' => array(
						'key' => 'circular_notice_content_3',
					),
					'CircularNoticeTargetUser' => array(
						'id' => 3,
						'reply_selection_value' => array(
							'3',
							'5'
						),
					),
				),
				'assert' => array('method' => 'assertEquals'),
			),
			array(
				'urlOptions' => Hash::insert($data, 'key', 'circular_notice_content_10'),
				'data' => array(
						'CircularNoticeContent' => array(
								'key' => 'circular_notice_content_10',
						),
						'CircularNoticeTargetUser' => array(
								'id' => 10,
								'reply_text_value' => '',
						),
				),
				'assert' => array('method' => 'assertEquals'),
			),
			array(
				'urlOptions' => Hash::insert($data, 'key', 'circular_notice_content_11'),
				'data' => array(
						'CircularNoticeContent' => array(
								'key' => 'circular_notice_content_11',
						),
						'CircularNoticeTargetUser' => array(
								'id' => 11,
								'reply_text_value' => '',
								'reply_selection_value' => '',
						),
				),
				'assert' => array('method' => 'assertEquals'),
			),
			array(
				'urlOptions' => Hash::insert($data, 'key', 'circular_notice_content_12'),
				'data' => array(
					'CircularNoticeContent' => array(
						'key' => 'circular_notice_content_12',
					),
					'CircularNoticeTargetUser' => array(
						'id' => 12,
						'reply_selection_value' => array(),
					),
				),
				'assert' => array('method' => 'assertEquals'),
			));
	}

/**
 * editアクションのPOSTテスト
 *
 * @param array $urlOptions URLオプション
 * @param array $data POSTデータ
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderEditPost
 * @return void
 */
	public function testEditPost($urlOptions, $data, $assert, $exception = null, $return = 'view') {
		//ログイン
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_GENERAL_USER);
		//テスト実施
		$this->_testPostAction('put', $data, Hash::merge(array('action' => 'edit'), $urlOptions), $exception, $return);
		//ログイン
		TestAuthGeneral::logout($this);
	}
}
