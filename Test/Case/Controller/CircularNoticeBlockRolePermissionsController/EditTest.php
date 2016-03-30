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
App::uses('FramesAppModel', 'Frames.Model');
App::uses('FrameFixture', 'Frames.Test/Fixture');
App::uses('BlocksAppModel', 'Blocks.Model');
App::uses('BlockFixture', 'Blocks.Test/Fixture');

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
    public function setUp()
    {
        parent::setUp();
        $this->Frame = ClassRegistry::init('Frames.Frame');
        $this->Block = ClassRegistry::init('Blocks.Block');
        // 例外データ作成
        $this->Frame->save(
            array(
                'id' => 19,
                'language_id' => 2,
                'room_id' => 5,
                'box_id' => 2,
                'plugin_key' => 'circular_notices',
                'block_id' => 5,
                'key' => 'frame_19',
                'name' => 'Test frame main',
                'header_type' => 'default',
                'weight' => 1,
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
                'id' => 33,
                'language_id' => 2,
                'room_id' => 1,
                'plugin_key' => 'circular_notices',
                'key' => 'false_key',
                'name' => 'Block_name_5',
                'public_type' => 2,
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
     * POSTリクエストデータ生成
     *
     * @return array リクエストデータ
     */
    private function __data()
    {
        $data = array(
            'Frame' => array(
                'id' => 6,
                'language_id' => '2',
                'room_id' => '1',
                'box_id' => '2',
                'plugin_key' => 'circular_notices',
                'block_id' => 6,
                'key' => 'circular_notices',
                'name' => '回覧板フレーム',
                'header_type' => 'default',
                'weight' => '2',
                'is_deleted' => false,
                'default_action' => '',
                'created_user' => '1',
                'created' => '2016-03-30 04:03:29',
                'modified_user' => '1',
                'modified' => '2016-03-30 04:03:29'
            ),
            'Block' => array(
                'id' => 5,
            ),
            'CircularNoticeFrameSetting' => array(
                'id' => 1,
                'frame_key' => 'frame_1',
                'display_number' => 10,
            ),
            'CircularNoticeSetting' => array(
                'id' => '1',
                'key' => 'circular_notices'
            )
        );
        return $data;
    }

    /**
     * edit()アクションのGetリクエストテスト
     *
     * @param array $urlOptions URLオプション
     * @param array $assert テストの期待値
     * @param string|null $exception Exception
     * @param string $return testActionの実行後の結果
     * @dataProvider dataProviderEditGet
     * @return void
     */
    public function testEditGet($urlOptions, $assert, $exception = null, $return = 'view') {
        // Exception
        if ($exception) {
            $this->setExpectedException($exception);
        }

        // テスト実施
        $url = Hash::merge(array(
            'plugin' => $this->plugin,
            'controller' => $this->_controller,
            'action' => 'edit',
        ), $urlOptions);

        $this->_testGetAction($url, $assert, $exception, $return);
    }

    /**
     * editアクションのGETテスト(ログインなし)用DataProvider
     *
     * #### 戻り値
     *  - urlOptions: URLオプション
     *  - assert: テストの期待値
     *  - exception: Exception
     *  - return: testActionの実行後の結果
     *
     * @return array
     */
    public function dataProviderEditGet() {
        $data = $this->__data();
        $results = array();

        //ログインなし
        $results[0] = array(
            'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => $data['CircularNoticeFrameSetting']['id']),
            'assert' => null, 'exception' => 'ForbiddenException'
        );
        return $results;
    }

    /**
     * editアクションのGETテスト
     *
     * @param array $urlOptions URLオプション
     * @param array $assert テストの期待値
     * @param string|null $exception Exception
     * @param string $return testActionの実行後の結果
     * @dataProvider dataProviderEditGetByPublishable
     * @return void
     */
    public function testEditGetByPublishable($urlOptions, $assert, $exception = null, $return = 'view') {
        //ログイン
        TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR);

        // Exception
        if ($exception) {
            $this->setExpectedException($exception);
        }
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
     * editアクションのGETテスト(ログインあり)用DataProvider
     *
     * #### 戻り値
     *  - urlOptions: URLオプション
     *  - assert: テストの期待値
     *  - exception: Exception
     *  - return: testActionの実行後の結果
     *
     * @return array
     */
    public function dataProviderEditGetByPublishable() {
        $data0 = $this->__data();
        $results = array();

        //ログインあり
        $results[0] = array(
            'urlOptions' => array('frame_id' => $data0['Frame']['id'], 'block_id' => $data0['Block']['id'], 'key' => $data0['CircularNoticeFrameSetting']['id']),
            'assert' => null, 'exception' => 'BadRequestException'
        );

        return $results;
    }

    /**
     * edit()アクションのGetリクエストテスト
     *
     * @param array $urlOptions URLオプション
     * @param array $assert テストの期待値
     * @param string|null $exception Exception
     * @param string $return testActionの実行後の結果
     * @dataProvider dataProviderEditGetOnException
     * @return void
     */
    public function testEditGetOnException($urlOptions, $assert, $exception = null, $return = 'view') {

        //ログイン
        TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR);
        // Exception
        if ($exception) {
            $this->setExpectedException($exception);
        }

        // テスト実施
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
     * editアクションのGETテスト
     *
     * #### 戻り値
     *  - urlOptions: URLオプション
     *  - assert: テストの期待値
     *  - exception: Exception
     *  - return: testActionの実行後の結果
     *
     * @return array
     */
    public function dataProviderEditGetOnException() {
        $results = array();

        $results[0] = array(
            'urlOptions' => array('block_id' => 5),
            'assert' => null, 'exception' => 'BadRequest'
        );
        $results[1] = array(
            'urlOptions' => array('frame_id' => 19),
            'assert' => null, 'exception' => 'InternalServerErrorException'
        );
//        $results[2] = array(
//            'urlOptions' => array('frame_id' => 19),
//            'assert' => null, 'exception' => null
//        );
        return $results;
    }

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
        if (isset($role)) {
            TestAuthGeneral::login($this, $role);
        }

        //テスト実施
        $this->_testPostAction('put', $data, Hash::merge(array('action' => 'edit'), $urlOptions), $exception, $return);

        //正常の場合、リダイレクト
        if (! $exception) {
            $header = $this->controller->response->header();
            $this->assertNotEmpty($header['Location']);
        }

        //ログアウト
        if (isset($role)) {
            TestAuthGeneral::logout($this);
        }
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
            array(
                'data' => $data, 'role' => null,
                'urlOptions' => array('frame_id' => $data['Frame']['id']),
                'exception' => 'ForbiddenException'
            ),
            // 正常
            array(
                'data' => $data, 'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
                'urlOptions' => array('frame_id' => $data['Frame']['id']),
            ),
//            // フレームID指定なしテスト
            array(
                'data' => array(), 'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
                'urlOptions' => array('frame_id' => $data['Frame']['id']),
            ),
        );
    }

    /**
     * ValidationErrorテスト
     *
     * @param array $data POSTデータ
     * @param array $urlOptions URLオプション
     * @param string|null $validationError ValidationError
     * @dataProvider dataProviderEditValidationError
     * @return void
     */
    public function testEditPostValidationError($data, $urlOptions, $validationError = null)
    {
        //ログイン
        TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR);

        //テスト実施
        $this->_testActionOnValidationError('post', $data, Hash::merge(array('action' => 'edit'), $urlOptions), $validationError);

        //ログアウト
        TestAuthGeneral::logout($this);
    }

    /**
     * ValidationErrorテスト用DataProvider
     *
     * #### 戻り値
     *  - data: 登録データ
     *  - urlOptions: URLオプション
     *  - validationError: バリデーションエラー
     *
     * @return array
     */
    public function dataProviderEditValidationError()
    {
        $data = $this->__data();


        $result = array(
            'data' => $data,
            'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'frame_key' => $data['Frame']['key']),
        );

        return array(
            //バリデーションエラー
            Hash::merge($result, array(
                'validationError' => array(
                    'field' => 'CircularNoticeSetting.id',
                    'value' => '',
                    'message' => __d('net_commons', 'Invalid request.'),
                )
            )),
        );
    }
}
