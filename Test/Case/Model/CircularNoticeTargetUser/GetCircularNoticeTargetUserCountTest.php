<?php
/**
 * CircularNoticeTargetUser::getCircularNoticeTargetUserCount()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsGetTest', 'NetCommons.TestSuite');

/**
 * CircularNoticeTargetUser::getCircularNoticeTargetUserCount()のテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Model\CircularNoticeTargetUser
 */
class CircularNoticeTargetUserGetCircularNoticeTargetUserCountTest extends NetCommonsGetTest {

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
	protected $_modelName = 'CircularNoticeTargetUser';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'getCircularNoticeTargetUserCount';

/**
 * getCircularNoticeTargetUserCount()のテスト
 *
 * @return void
 */
	public function testGetCircularNoticeTargetUserCount() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		$contentId = null;

		//テスト実施
		$result = $this->$model->$methodName($contentId);

		//チェック
		$this->assertNotEmpty($result);
	}

}
