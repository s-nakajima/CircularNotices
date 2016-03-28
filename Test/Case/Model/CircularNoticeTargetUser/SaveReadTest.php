<?php
/**
 * CircularNoticeTargetUser::saveRead()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsSaveTest', 'NetCommons.TestSuite');
App::uses('CircularNoticesAppModel', 'CircularNotices.Model');
App::uses('CircularNoticeTargetUserFixture', 'CircularNotices.Test/Fixture');
App::uses('CircularNoticeContentFixture', 'CircularNotices.Test/Fixture');
App::uses('CircularNoticeTargetUserFixture', 'CircularNotices.Test/Fixture');

/**
 * CircularNoticeTargetUser::saveRead()のテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Model\CircularNoticeTargetUser
 */
class CircularNoticeTargetUserSaveReadTest extends NetCommonsSaveTest
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
    protected $_methodName = 'saveRead';

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();
        $this->CircularNoticeContent = ClassRegistry::init('CircularNotices.CircularNoticeContent');
        $this->TargetUser = ClassRegistry::init('CircularNotices.CircularNoticeTargetUser');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown() {
        unset($this->CircularNoticeContent);
        unset($this->TargetUser);

        parent::tearDown();
    }
    
    

    /**
     * Save用DataProvider
     *
     * ### 戻り値
     *  - data 登録データ
     *
     * @return array テストデータ
     */
//    public function dataProviderSave()
    public function dataProviderSave()
    {
        $data['CircularNoticeTargetUser'] = (new CircularNoticeTargetUserFixture())->records[0];
        $data['CircularNoticeContent'] = (new CircularNoticeContentFixture())->records[0];

        //TODO:テストパタンを書く
        $results = array();
        // * 編集の登録処理
        $results[0] = array($data);
        // * 新規の登録処理
        $results[1] = array($data);
        $results[1] = Hash::insert($results[1], '0.CircularNoticeTargetUser.id', null);
        $results[1] = Hash::insert($results[1], '0.CircularNoticeTargetUser.key', null); //TODO:不要なら削除する
        $results[1] = Hash::remove($results[1], '0.CircularNoticeTargetUser.created_user');
    }


    /**
     * SaveのExceptionError用DataProvider
     *
     * ### 戻り値
     *  - data 登録データ
     *  - mockModel Mockのモデル
     *  - mockMethod Mockのメソッド
//     * @dataProvider dataProviderSave
     * @return array テストデータ
     */
    public function dataProviderSaveOnExceptionError()
    {
//        debug($this->dataProviderSave());
//        $data = $this->dataProviderSave()[0][0];
        $data['CircularNoticeTargetUser'] = (new CircularNoticeTargetUserFixture())->records[0];
        $data['CircularNoticeContent'] = (new CircularNoticeContentFixture())->records[0];
        //TODO:テストパタンを書く
        $results = array();
        // * 編集の登録処理
        $results[0] = array($data);
        // * 新規の登録処理
        $results[1] = array($data);
        $results[1] = Hash::insert($results[1], '0.CircularNoticeTargetUser.id', null);
        $results[1] = Hash::insert($results[1], '0.CircularNoticeTargetUser.key', null); //TODO:不要なら削除する
        $results[1] = Hash::remove($results[1], '0.CircularNoticeTargetUser.created_user');

        //TODO:テストパタンを書く
        return array(
            array($data, 'CircularNotices.CircularNoticeTargetUser', 'save'),
            array($data, 'CircularNotices.CircularNoticeContent', 'save'),
        );
    }

    /**
     * SaveのValidationError用DataProvider
     *
     * ### 戻り値
     *  - data 登録データ
     *  - mockModel Mockのモデル
     *  - mockMethod Mockのメソッド(省略可：デフォルト validates)
     *
     * @return array テストデータ
     */
    public function dataProviderSaveOnValidationError()
    {
        $data = $this->dataProviderSave()[0][0];

        //TODO:テストパタンを書く
        return array(
            array($data, 'CircularNotices.CircularNoticeTargetUser'),
        );
    }

    /**
     * SaveRead()の例外テスト
     *
     * @return void
     */
    public function testSaveRead()
    {
        $model = $this->_modelName;
        $methodName = $this->_methodName;
//        $this->setExpectedException('InternalErrorException');

        $this->TargetUser->save(
            array('id' => '4',
                'user_id' => 4,
                'circular_notice_content_id' => 7,
                'read_flag' => 0,
                'read_datetime' => '2015-03-09 09:25:24',
                'reply_flag' => 1,
                'reply_datetime' => '2015-03-09 09:25:24',
                'reply_text_value' => 'Lorem ipsum dolor sit amet',
                'reply_selection_value' => 'Lorem ipsum dolor sit amet',
                'created_user' => 1,
                'created' => '2015-03-09 09:25:24',
                'modified_user' => 1,
                'modified' => '2015-03-09 09:25:24'
            )
        );
        $this->CircularNoticeContent->save(
            array(
                'id' => '7',
                'key' => 'frame_4',
                'circular_notice_setting_key' => 'frame_4',
                'subject' => true,
                'content' => 'frame_4',
                'reply_type' => '1',
                'is_room_targeted_flag' => true,
                'target_groups' => 'frame_4',
                'publish_start' => '2015-03-31 09:25:20',
                'publish_end' => '2017-04-01 23:59:59',
                'reply_deadline_set_flag' => 1,
                'reply_deadline' => '2017-04-01 23:25:20',
                'status' => '1',
                'is_auto_translated' => true,
                'translation_engine' => 'frame_4',
                'created_user' => '1',
                'created' => '2015-03-09 09:25:20',
                'modified_user' => '1',
                'modified' => '2015-03-09 09:25:20',
                'current_status' => '7'
            )
        );

        $contentId = 7;
        $userId = 4;

        // 例外モック
//        $circularNoticeSettingMock = $this->getMockForModel('CircularNotices.' . $model, ['saveCircularNoticeTargetUser']);
//        $circularNoticeSettingMock->expects($this->any())
//            ->method('saveCircularNoticeTargetUser')
//            ->will($this->returnValue(false));
//        $result = $circularNoticeSettingMock->$methodName($contentId,$userId);




        //テスト実施
        $result = $this->$model->$methodName($contentId, $userId);
        //チェック
        //TODO:Assertを書く
    }

    /**
     * SaveRead()の例外テスト
     *
     * @return void
     */
    public function testSaveReadExceptionError()
    {
        $this->setExpectedException('InternalErrorException');
        $this->TargetUser->save(
            array('id' => '4',
					'user_id' => 4,
					'circular_notice_content_id' => 7,
					'read_flag' => 0,
					'read_datetime' => '2015-03-09 09:25:24',
					'reply_flag' => 1,
					'reply_datetime' => '2015-03-09 09:25:24',
					'reply_text_value' => 'Lorem ipsum dolor sit amet',
					'reply_selection_value' => 'Lorem ipsum dolor sit amet',
					'created_user' => 1,
					'created' => '2015-03-09 09:25:24',
					'modified_user' => 1,
					'modified' => '2015-03-09 09:25:24'
                )
        );
        $this->CircularNoticeContent->save(
            array(
                'id' => '7',
                'key' => 'frame_4',
                'circular_notice_setting_key' => 'frame_4',
                'subject' => true,
                'content' => 'frame_4',
                'reply_type' => '1',
                'is_room_targeted_flag' => true,
                'target_groups' => 'frame_4',
                'publish_start' => '2015-03-31 09:25:20',
                'publish_end' => '2017-04-01 23:59:59',
                'reply_deadline_set_flag' => 1,
                'reply_deadline' => '2017-04-01 23:25:20',
                'status' => '1',
                'is_auto_translated' => true,
                'translation_engine' => 'frame_4',
                'created_user' => '1',
                'created' => '2015-03-09 09:25:20',
                'modified_user' => '1',
                'modified' => '2015-03-09 09:25:20',
                'current_status' => '7'
                )
        );

        $model = $this->_modelName;
        $methodName = $this->_methodName;

        $contentId = 7;
        $userId = 4;

        // 例外モック
        $circularNoticeSettingMock = $this->getMockForModel('CircularNotices.' . $model, ['saveCircularNoticeTargetUser']);
		$circularNoticeSettingMock->expects($this->any())
				->method('saveCircularNoticeTargetUser')
				->will($this->returnValue(false));
		$result = $circularNoticeSettingMock->$methodName($contentId,$userId);

        //チェック
        //TODO:Assertを書く
    }

    /**
     * SaveRead()の例外テスト
     *
     * @return void
     */
    public function testSaveReadSecondExceptionError()
    {
        $model = $this->_modelName;
        $methodName = $this->_methodName;
        $this->setExpectedException('InternalErrorException');

        $this->TargetUser->save(
            array('id' => '5',
                'user_id' => 5,
                'circular_notice_content_id' => 8,
                'read_flag' => 0,
                'read_datetime' => '2015-03-09 09:25:24',
                'reply_flag' => 1,
                'reply_datetime' => '2015-03-09 09:25:24',
                'reply_text_value' => 'Lorem ipsum dolor sit amet',
                'reply_selection_value' => 'Lorem ipsum dolor sit amet',
                'created_user' => 1,
                'created' => '2015-03-09 09:25:24',
                'modified_user' => 1,
                'modified' => '2015-03-09 09:25:24'
            )
        );
        $this->CircularNoticeContent->save(
            array(
                'id' => '8',
                'key' => 'frame_4',
                'circular_notice_setting_key' => 'frame_4',
                'subject' => true,
                'content' => 'frame_4',
                'reply_type' => '1',
                'is_room_targeted_flag' => true,
                'target_groups' => 'frame_4',
                'publish_start' => '2016-03-10 09:25:20',
                'publish_end' => '2017-04-01 23:59:59',
                'reply_deadline_set_flag' => 1,
                'reply_deadline' => '2016-03-24 23:25:20',
                'status' => '1',
                'is_auto_translated' => true,
                'translation_engine' => 'frame_4',
                'created_user' => '1',
                'created' => '2015-03-09 09:25:20',
                'modified_user' => '1',
                'modified' => '2015-03-09 09:25:20',
                'current_status' => '6'
            )
        );

        $contentId = 8;
        $userId = 5;

        // 例外モック
        $circularNoticeSettingMock = $this->getMockForModel('CircularNotices.' . $model, ['saveCircularNoticeTargetUser']);
        $circularNoticeSettingMock->expects($this->any())
            ->method('saveCircularNoticeTargetUser')
            ->will($this->returnValue(false));
        $result = $circularNoticeSettingMock->$methodName($contentId,$userId);





        //チェック
        //TODO:Assertを書く
    }

}
