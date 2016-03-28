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
App::uses('WorkflowComponent', 'Workflow.Controller/Component');

/**
 * CircularNoticeTargetUserBehavior::validates()のテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Model\Behavior\CircularNoticeTargetUserBehavior
 */
class CircularNoticeTargetUserBehaviorValidatesTest extends NetCommonsModelTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'plugin.circular_notices.test_circular_notice_target_user_behavior_validates_model',
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
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
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
    public function testValidate()
    {
        //テストデータ
        $data = array(
            'TestCircularNoticeTargetUserBehaviorValidatesModel' => (new TestCircularNoticeTargetUserBehaviorValidatesModelFixture())->records[0],
            'CircularNoticeContent' => (new CircularNoticeContentFixture())->records[0],
        );

        //テスト実施
        $result = $this->TestModel->set($data);
        //チェック
//        $this->assertFalse($result);
        //テスト実施
        $result = $this->TestModel->validates();
        //チェック
        $this->assertFalse($result);

        //テストデータ
        $data['CircularNoticeTargetUser'][] = array(
            'user_id' => 1
        );

        //テスト実施
        $result = $this->TestModel->set($data);
        //チェック
//        $this->assertFalse($result);
        //テスト実施
        $result = $this->TestModel->validates();
        //チェック
        $this->assertFalse($result);
    }

    public function testIsRoomTargetedFlagOn()
    {
        //テストデータ
        $data = array(
            'TestCircularNoticeTargetUserBehaviorValidatesModel' => (new TestCircularNoticeTargetUserBehaviorValidatesModelFixture())->records[0],
            'CircularNoticeContent' => (new CircularNoticeContentFixture())->records[1],
        );

        //テスト実施
        $result = $this->TestModel->set($data);
        //チェック
//        $this->assertTrue($result);
        //テスト実施
        $result = $this->TestModel->validates();
        //チェック
        $this->assertTrue($result);
    }

    public function testValidationError()
    {
        //テストデータ
        $data = array(
            'TestCircularNoticeTargetUserBehaviorValidatesModel' => (new TestCircularNoticeTargetUserBehaviorValidatesModelFixture())->records[0],
            'CircularNoticeContent' => (new CircularNoticeContentFixture())->records[0],
            'CircularNoticeTargetUser' => array(
                0 => array('user_id' => 'error_data')
            )
        );

        $circularNoticeChoicesMock = $this->getMockForModel('TestCircularNotices.'.'TestCircularNoticeTargetUserBehaviorValidatesModel', ['validates']);
        $circularNoticeChoicesMock->expects($this->any())
            ->method('validates')
            ->will($this->returnValue(true));

        //テスト実施
        $result = $this->TestModel->set($data);
        //チェック
//        $this->assertFalse($result);
        //テスト実施
        $result = $this->TestModel->validates();
        //チェック
        $this->assertFalse($result);
    }
}
