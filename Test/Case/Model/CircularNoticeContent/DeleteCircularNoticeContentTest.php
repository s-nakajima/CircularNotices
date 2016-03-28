<?php
/**
 * CircularNoticeContent::deleteCircularNoticeContent()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsDeleteTest', 'NetCommons.TestSuite');
App::uses('CircularNoticeContentFixture', 'CircularNotices.Test/Fixture');
App::uses('CircularNoticesAppModel', 'CircularNotices.Model');
App::uses('CircularNoticeTargetUserFixture', 'CircularNotices.Test/Fixture');
App::uses('CircularNoticeContentFixture', 'CircularNotices.Test/Fixture');
App::uses('CircularNoticeTargetUserFixture', 'CircularNotices.Test/Fixture');


/**
 * CircularNoticeContent::deleteCircularNoticeContent()のテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Model\CircularNoticeContent
 */
class CircularNoticeContentDeleteCircularNoticeContentTest extends NetCommonsDeleteTest {

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
	protected $_methodName = 'deleteCircularNoticeContent';

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
 * Delete用DataProvider
 *
 * ### 戻り値
 *  - data: 削除データ
 *  - associationModels: 削除確認の関連モデル array(model => conditions)
 *
 * @return array テストデータ
 */
	public function dataProviderDelete() {

		$data['CircularNoticeContent'] = (new CircularNoticeContentFixture())->records[1];
		$data['CircularNoticeTargetUser'] = (new CircularNoticeTargetUserFixture())->records[1];
		$association = array();

		$results = array();
		$results[0][0] = array($data['CircularNoticeContent'], $association);
		$results[0][1] = array($data['CircularNoticeTargetUser'], $association);

		return $results;
	}

/**
 * ExceptionError用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return array テストデータ
 */
	public function dataProviderDeleteOnExceptionError() {
		$this->setExpectedException('InternalErrorException');

		$data = $this->dataProviderDelete()[0][0];
//		$data['CircularNoticeContent'] = (new CircularNoticeContentFixture())->records[0];
		$key = 1;
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		//テスト実施
//		$result = $this->$model->$methodName($key);
		     
		
		return array(
			array($data[0]['key'], 'CircularNotices.CircularNoticeContent', 'deleteAll'),
		);
	}
	
	
	/**
// * ExceptionError
 *
 * @return void
 */
	public function testCircularNoticeContentDelete() {
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
		
		$result = $this->CircularNoticeContent->find('all');
		
		

//		$data['CircularNoticeContent'] = $this->dataProviderDelete()[0][0];
		$key = 'frame_4';
//		$this->setExpectedException('InternalErrorException');
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$result = $this->$model->$methodName($key);
		
//		$circularNoticeSettingMock = $this->getMockForModel('CircularNotices.' . $model, ['find']);
//		$circularNoticeSettingMock->expects($this->any())
//				->method('find')
//				->will($this->returnValue(1));
//		$result = $circularNoticeSettingMock->$methodName('frame_1');
	}

}
