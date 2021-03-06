<?php
/**
 * CircularNoticesAppModel::validateDatetimeBetween()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * CircularNoticesAppModel::validateDatetimeBetween()のテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Model\CircularNoticesAppModel
 */
class CircularNoticeContentValidateDatetimeBetweenTest extends NetCommonsModelTestCase {

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
	protected $_methodName = 'validateDatetimeBetween';

/**
 * validateDatetimeBetween()のテスト
 *
 * @return void
 */
	public function testValidateDatetimeBetween() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		$check = array(
			'reply_deadline' => '2016-03-23 23:59'
		);
		$params = array(
			'from' => '2016-03-23 00:00',
			'to' => '2016-03-24 00:00'
		);

		//テスト実施
		$result = $this->$model->$methodName($check, $params);

		//チェック
		$this->assertTrue($result);
	}

/**
 * validateDatetimeBetween()のエラーテスト
 *
 * @return void
 */
	public function testValidateDatetimeBetweenFalse() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		$check = array(
			'reply_deadline' => ''
		);
		$params = array(
			'from' => '2016-03-24 00:00',
			'to' => '2016-03-23 00:00'
		);

		//テスト実施
		$result = $this->$model->$methodName($check, $params);

		//チェック
		$this->assertFalse($result);
	}
}
