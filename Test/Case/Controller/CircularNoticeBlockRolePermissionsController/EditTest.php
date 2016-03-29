<?php
/**
 * CircularNoticeBlockRolePermissionsController::edit()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');
//App::uses('BlockRolePermissionsControllerEditTest', 'Blocks.TestSuite');
//App::uses('FramesAppModel', 'Frames.Model');
//App::uses('FrameFixture', 'Frames.Test/Fixture');
//App::uses('BlocksAppModel', 'Blocks.Model');
//App::uses('BlockFixture', 'Blocks.Test/Fixture');

/**
 * CircularNoticeBlockRolePermissionsController::edit()のテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Controller\CircularNoticeBlockRolePermissionsController
 */
class CircularNoticeBlockRolePermissionsControllerEditTest extends NetCommonsControllerTestCase
//class CircularNoticeBlockRolePermissionsControllerEditTest extends BlockRolePermissionsControllerEditTest
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
    protected $_controller = 'circular_notice_block_role_permissions';

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();
        $this->Frame = ClassRegistry::init('Frames.Frame');
        $this->Block = ClassRegistry::init('Blocks.Block');
        // 例外データ作成
        $this->Frame->save(
            array(
                'id' => '19',
                'language_id' => '2',
                'room_id' => '5',
                'box_id' => 2,
                'plugin_key' => 'circular_notices',
                'block_id' => 33,
                'key' => 'frame_19',
                'name' => 'Test frame main',
                'header_type' => 'default',
                'weight' => '1',
                'is_deleted' => false,
                'default_action' => '',
                'created_user' => null,
                'created' => null,
                'modified_user' => null,
                'modified' => null
            ),
            array(
                'id' => 20,
                'language_id' => '2',
                'room_id' => '5',
                'box_id' => 2,
                'plugin_key' => 'circular_notices',
                'block_id' => null,
                'key' => 'frame_20',
                'name' => 'Test frame main',
                'header_type' => 'default',
                'weight' => '1',
                'is_deleted' => false,
                'default_action' => '',
                'created_user' => null,
                'created' => null,
                'modified_user' => null,
                'modified' => null
            ),
            array(
                'id' => 21,
                'language_id' => '2',
                'room_id' => '5',
                'box_id' => 2,
                'plugin_key' => 'circular_notices',
                'block_id' => null,
                'key' => 'frame_21',
                'name' => 'Test frame main',
                'header_type' => 'default',
                'weight' => '1',
                'is_deleted' => false,
                'default_action' => '',
                'created_user' => null,
                'created' => null,
                'modified_user' => null,
                'modified' => null
            )
        );
        $this->Block->save(
            array(
                'id' => '33',
                'language_id' => '2',
                'room_id' => '1',
                'plugin_key' => 'circular_notices',
                'key' => 'false_key',
                'name' => 'Block name 5',
                'public_type' => '2',
                'publish_start' => null,
                'publish_end' => null,
                'created_user' => null,
                'created' => null,
                'modified_user' => null,
                'modified' => null
            )
        );
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown() {
        unset($this->Frame);
        unset($this->Block);

        parent::tearDown();
    }
//
//    /**
//     * 権限設定で使用するFieldsの取得
//     *
//     * @return array
//     */
//    private function __approvalFields()
//    {
//        $data = array(
//            'CircularNoticeSetting' => array(
//                'use_workflow',
//                'use_comment_approval',
//                'approval_type',
//            )
//        );
//
//        return $data;
//    }

    /**
     * テストDataの取得
     *
     * @return array
     */
    private function __data()
    {
        $data = array(
            'CircularNoticeSetting' => array(
                'id' => '5',
                'block_key' => 'block_1',
                'key' => 'circular_notice_4',
                'mail_notice_flag' => 1,
                'mail_subject' => 'frame_1',
                'mail_body' => 'frame_1',
                'is_auto_translated' => 1,
                'translation_engine' => 'frame_1',
                'created_user' => '1',
                'created' => '2015-03-09 09:25:26',
                'modified_user' => 1,
                'modified' => '2015-03-09 09:25:26',
//                'id' => 2,
//                'circular_notice_key' => 'circular_notice_key_2',
                'use_workflow' => true,
                'use_comment_approval' => true,
                'approval_type' => true,
            ),
//            'BlockRolePermission' => array(
//                'id' => '1',
//                'roles_room_id' => '4',
//                'block_key' => 'block_1',
//                'permission' => 'content_creatable',
//                'value' => true,
//            ),
//            'Block' => array(
//                'id' => '8',
//                'language_id' => '2',
//                'room_id' => '1',
//                'plugin_key' => 'circular_notices',
//                'key' => 'false_key',
//                'name' => 'Block_name_5',
//                'public_type' => '2',
//                'publish_start' => null,
//                'publish_end' => null,
//                'created_user' => null,
//                'created' => '2016-03-29 11:34:07',
//                'modified_user' => null,
//                'modified' => '2016-03-29 11:34:07'
//            ),
            array(
                'Frame' => array(
                    'id' => 19,
                )
            )
            
        );

        return $data;
    }

//    /**
//     * edit()アクションDataProvider
//     *
//     * ### 戻り値
//     *  - approvalFields コンテンツ承認の利用有無のフィールド
//     *  - exception Exception
//     *  - return testActionの実行後の結果
//     *
//     * @return array
//     */
//    public function dataProviderEditFieldGet()
//    {
//        return array(
//            array('approvalFields' => $this->__approvalFields())
//        );
//    }
//
//    /**
//     * edit()アクションDataProvider
//     *
//     * ### 戻り値
//     *  - approvalFields コンテンツ承認の利用有無のフィールド
//     *  - exception Exception
//     *  - return testActionの実行後の結果
//     *
//     * @return array
//     */
//    public function dataProviderDataEditGet()
//    {
//        return array(
//            array('data' => $this->__data())
//        );
//    }

//    /**
//     * edit()アクションのGetリクエストテスト
//     *
//     * @param array $urlOptions URLオプション
//     * @param array $assert テストの期待値
//     * @param string|null $exception Exception
//     * @param string $return testActionの実行後の結果
//     * @dataProvider dataProviderEditGet
//     * @return void
//     */
//    public function testEditGet($urlOptions, $assert, $exception = null, $return = 'view') {
//
//        //ログイン
//        TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR);
//        // Exception
//        if ($exception) {
//            $this->setExpectedException($exception);
//        }
//
//        // テスト実施
//        $url = Hash::merge(array(
//            'plugin' => $this->plugin,
//            'controller' => $this->_controller,
//            'action' => 'edit',
//        ), $urlOptions);
//
//        $this->_testGetAction($url, $assert, $exception, $return);
//        //ログアウト
//        TestAuthGeneral::logout($this);
//    }
//
//    /**
//     * editアクションのGETテスト
//     *
//     * #### 戻り値
//     *  - urlOptions: URLオプション
//     *  - assert: テストの期待値
//     *  - exception: Exception
//     *  - return: testActionの実行後の結果
//     *
//     * @return array
//     */
//    public function dataProviderEditGet() {
//        $results = array();
//
//        $results[0] = array(
//            'urlOptions' => array('block_id' => 10),
//            'assert' => null, 'exception' => 'BadRequestException'
//        );
////        $results[1] = array(
////            'urlOptions' => array('frame_id' => 19),
////            'assert' => null, 'exception' => 'BadRequestException'
////        );
//        $results[2] = array(
//            'urlOptions' => array('frame_id' => 20),
//            'assert' => null, 'exception' => 'BadRequestException'
////            'assert' => null, 'exception' => null
//        );
////        $results[3] = array(
////            'urlOptions' => array('frame_id' => 13),
////            'assert' => null, 'exception' => 'BadRequestException'
////        );
//        return $results;
//    }

    /**
     * edit()アクションのPOSTリクエストテスト
     *
     * @param array $data POSTデータ
     * @param string $role ロール
     * @param array $urlOptions URLオプション
     * @param string|null $exception Exception
     * @param string $return testActionの実行後の結果
     * @dataProvider dataProviderEditPost
     * @return void
     */
    public function testEditPost($data, $role, $urlOptions, $exception = null, $return = 'view') {
        // ログイン
//        if (isset($role)) {
//            TestAuthGeneral::login($this, $role);
//        }

        //ログイン
        TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR);
        //テスト実施
//        $this->_testPostAction('put', $data, Hash::merge(array('action' => 'edit'), $urlOptions), $exception, $return);
        $this->_testPostAction('put', $data, array('action' => 'edit'), $exception, $return);

        //正常の場合、リダイレクト
        if (! $exception) {
            $header = $this->controller->response->header();
            $this->assertNotEmpty($header['Location']);
        }

//        //ログアウト
//        if (isset($role)) {
//            TestAuthGeneral::logout($this);
//        }
        //ログアウト
        TestAuthGeneral::logout($this);
    }

    /**
     * editアクションのPOSTテスト用DataProvider
     *
     * #### 戻り値
     *  - data: 登録データ
     *  - role: ロール
     *  - urlOptions: URLオプション
     *  - exception: Exception
     *  - return: testActionの実行後の結果
     *
     * @return array
     */
    public function dataProviderEditPost() {
        $data = $this->__data();

        return array(
            // ログインなし
//            array(
//                'data' => $data, 'role' => null,
//                'urlOptions' => array('frame_id' => 6),
//                'exception' => 'ForbiddenException'
//            ),
            // 正常
            array(
                'data' => $data, 'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
                'urlOptions' => array('frame_id' => 6),
                'exception' => null
//                'exception' => 'ForbiddenException'
            ),
        );
    }

}
