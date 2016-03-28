<?php
/**
 * CircularNoticesAppController::beforeFilter()のテスト
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
 * CircularNoticesAppController::beforeFilter()のテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Controller\CircularNoticesAppController
 */
class CircularNoticesAppControllerBeforeFilterTest extends NetCommonsControllerTestCase
{

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
    public function setUp()
    {
        parent::setUp();

        //テストプラグインのロード
        NetCommonsCakeTestCase::loadTestPlugin($this, 'CircularNotices', 'TestCircularNotices');
        $this->generateNc('TestCircularNotices.TestCircularNoticesAppControllerIndex');
    }

    /**
     * beforeFilter()のテスト
     *
     * @return void
     */
    public function testBeforeFilter()
    {
        // ログイン
        TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR);
        
        //TODO:テストデータ

        //テスト実行
        $this->_testGetAction('/test_circular_notices/test_circular_notices_app_controller_index/index', null);

        // ログアウト
        TestAuthGeneral::logout($this, Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR);
        
        
        //チェック
        //TODO:assert追加
    }
}
