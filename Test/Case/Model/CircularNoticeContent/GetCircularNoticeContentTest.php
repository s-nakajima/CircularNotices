<?php
/**
 * CircularNoticeContent::getCircularNoticeContent()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsGetTest', 'NetCommons.TestSuite');

/**
 * CircularNoticeContent::getCircularNoticeContent()のテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Model\CircularNoticeContent
 */
class CircularNoticeContentGetCircularNoticeContentTest extends NetCommonsGetTest {

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
 * Model name
 *
 * @var string
 */
	protected $_modelName = 'CircularNoticeContent';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'getCircularNoticeContent';

/**
 * getCircularNoticeContentのDataProvider
 *
 * ### 戻り値
 *  - key CircularNoticeContentのkey
 *  - userId ユーザID
 *
 * @return array
 */
	public function dataProvider() {
		return array(
			array(
				'key' => 'circular_notice_content_1',
				'userId' => '1',
				'array'
			),
			array(
				'key' => 'circular_notice_content_2',
				'userId' => null,
				'boolean',
			),
		);
	}

/**
 * getCircularNoticeContent()のテスト
 *
 * @param string $key CircularNoticeContentのkey
 * @param int $userId ユーザID
 * @param array $expected 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testGetCircularNoticeContent($key, $userId, $expected) {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//テスト実施
		$result = $this->$model->$methodName($key, $userId);

		//チェック
		$this->assertInternalType($expected, $result);
	}
}
