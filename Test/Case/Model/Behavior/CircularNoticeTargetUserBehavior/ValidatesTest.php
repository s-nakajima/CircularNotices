<?php
/**
 * CircularNoticeTargetUserBehavior::validates()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('TestCircularNoticeTargetUserBehaviorValidatesModelFixture', 'CircularNotices.Test/Fixture');

/**
 * CircularNoticeTargetUserBehavior::validates()のテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Model\Behavior\CircularNoticeTargetUserBehavior
 */
class CircularNoticeTargetUserBehaviorValidatesTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.circular_notices.test_circular_notice_target_user_behavior_validates_model',
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
		$this->TestModel = ClassRegistry::init('TestCircularNotices.TestCircularNoticeTargetUserBehaviorValidatesModel');
	}

/**
 * validates()のテスト
 *
 * @return void
 */
	public function testValidates() {
		//テストデータ
		$data = array(
			'TestCircularNoticeTargetUserBehaviorValidatesModel' => (new TestCircularNoticeTargetUserBehaviorValidatesModelFixture())->records[0],
		);

		//テスト実施
		$this->TestModel->set($data);
		$result = $this->TestModel->validates();

		//チェック
		//TODO:Assertを書く
		debug($this->TestModel->validationErrors);
		debug($result);
	}

}
