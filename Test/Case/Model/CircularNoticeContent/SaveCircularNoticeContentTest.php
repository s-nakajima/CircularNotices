<?php
/**
 * CircularNoticeContent::saveCircularNoticeContent()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('CircularNoticeContentTest', 'CircularNotices.CircularNoticeContent');
App::uses('CircularNoticeContentFixture', 'CircularNotices.Test/Fixture');
App::uses('CircularNoticeTargetUserFixture', 'CircularNotices.Test/Fixture');
App::uses('CircularNoticeChoiceFixture', 'CircularNotices.Test/Fixture');

/**
 * CircularNoticeContent::saveCircularNoticeContent()のテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Model\CircularNoticeContent
 */
class CircularNoticeContentSaveCircularNoticeContentTest extends NetCommonsModelTestCase {

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
		'plugin.site_manager.site_setting'
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
	protected $_methodName = 'saveCircularNoticeContent';

	public function setUp() {
		parent::setUp();
		Current::$current['Room']['id'] = '1';
	}

/**
 * data
 *
 * @var array
 */
	//private $__data = array(
	//	'Frame' => array(
	//		'id' => '6'
	//	),
	//	'Block' => array(
	//		'id' => '1',
	//		'key' => 'block_2',
	//		'language_id' => '2',
	//		'room_id' => '1',
	//		'plugin_key' => 'access_counters',
	//		'key' => 'block_2',
	//		'public_type' => '1',
	//	),
	//	'CircularNoticeContent' => array(
	//		'id' => 7,
	//		'key' => 'frame_4',
	//		'circular_notice_setting_key' => 'frame_4',
	//		'public_type' => 1,
	//		'subject' => true,
	//		'content' => 'frame_4',
	//		'reply_type' => 1,
	//		'is_room_targeted_flag' => true,
	//		'target_groups' => 'frame_4',
	//		'publish_start' => '2015-03-31 09:25:20',
	//		'publish_end' => '2017-04-01 23:59:59',
	//		'reply_deadline_set_flag' => 1,
	//		'reply_deadline' => '2017-04-01 23:25:20',
	//		'status' => 1,
	//		'is_auto_translated' => true,
	//		'translation_engine' => 'frame_4',
	//		'created_user' => 1,
	//		'created' => '2015-03-09 09:25:20',
	//		'modified_user' => 1,
	//		'modified' => '2015-03-09 09:25:20'
	//	),
	//	'CircularNoticeChoices' => array(
	//		0 => array(
	//			'CircularNoticeChoice' => array(
	//				'id' => '1',
	//				'weight' => '1',
	//				'value' => 'test'
	//			)
	//		),
	//		1 => array(
	//			'CircularNoticeChoice' => array(
	//				'id' => '2',
	//				'weight' => '2',
	//				'value' => 'tst'
	//			)
	//		),
	//		2 => array(
	//			'CircularNoticeChoice' => array(
	//				'id' => '',
	//				'weight' => '3',
	//				'value' => 'aaaaa'
	//			)
	//		)
	//	),
	//	'CircularNoticeTargetUser' => array(
	//		0 => array(
	//			'user_id' => '1'
	//		)
	//	),
	//	'CircularNoticeTargetUsers' => array(
	//		0 => array(
	//			'CircularNoticeTargetUser' => array(
	//				'id' => null,
	//				'user_id' => '1'
	//			)
	//		)
	//	)
	//);

	//	/**
	//	 * Save用DataProvider
	//	 *
	//	 * ### 戻り値
	//	 *  - data 登録データ
	//	 *
	//	 * @return array テストデータ
	//	 */
	//	public function dataProviderSave()
	//	{
	//		return array(
	//			array($this->__data, 0),
	//		);
	//	}
	//
	//	/**
	//	 * SaveのExceptionError用DataProvider
	//	 *
	//	 * ### 戻り値
	//	 *  - data 登録データ
	//	 *  - mockModel Mockのモデル
	//	 *  - mockMethod Mockのメソッド
	//	 *
	//	 * @return array テストデータ
	//	 */
	//	public function dataProviderSaveOnExceptionError()
	//	{
	//		return array(
	//			array($this->__data, 'CircularNotices.CircularNoticeContent', 'save'),
	//		);
	//	}

/**
 * SaveCircularNoticeContentのテスト
 *
 * @return void
 */
	public function testSaveCircularNoticeContent() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		$data['CircularNoticeContent'] = (new CircularNoticeContentFixture())->records[8];
		$data['CircularNoticeTargetUser'] = (new CircularNoticeTargetUserFixture())->records;
		$data['CircularNoticeChoices'] = (new CircularNoticeChoiceFixture())->records[0];

		//テスト実施
		$this->$model->$methodName($data);
	}

/**
 * SaveCircularNoticeContentのFalseテスト
 *
 * @return void
 */
	public function testSaveCircularNoticeContentFalse() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		$data['CircularNoticeContent'] = (new CircularNoticeContentFixture())->records[6];
		$data['CircularNoticeTargetUser'] = (new CircularNoticeTargetUserFixture())->records[0];
		$data['CircularNoticeChoices'] = [(new CircularNoticeChoiceFixture())->records[0]];

		//テスト実施
		$this->$model->$methodName($data);
	}

/**
 * ChoiceValidateCircularChoicesのFalseテスト
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド(省略可：デフォルト validates)
 *
 * @return void
 */
	public function testCircularNoticeChoiceValidateCircularChoices() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		$data['CircularNoticeContent'] = (new CircularNoticeContentFixture())->records[6];
		$data['CircularNoticeTargetUser'] = (new CircularNoticeTargetUserFixture())->records;
		$data['CircularNoticeChoices'] = [(new CircularNoticeChoiceFixture())->records[0]];

		$this->_mockForReturnFalse($model, 'CircularNotices.CircularNoticeChoice', 'validateCircularChoices');
		//テスト実施
		$this->$model->$methodName($data);
	}

/**
 * Saveの例外テスト
 *
 * @return void
 */
	public function testSaveCircularNoticeContentException() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$this->setExpectedException('InternalErrorException');

		$data['CircularNoticeContent'] = (new CircularNoticeContentFixture())->records[6];
		$data['CircularNoticeTargetUser'] = (new CircularNoticeTargetUserFixture())->records;
		$data['CircularNoticeChoices'] = (new CircularNoticeChoiceFixture())->records[0];

		// 例外を発生させるためのモック
		$thisModelMock = $this->getMockForModel('CircularNotices.' . $model, ['save']);
		$thisModelMock->expects($this->any())
				->method('save')
				->will($this->returnValue(false));

		//テスト実施
		$thisModelMock->$methodName($data);
	}

/**
 * ValidateCircularChoicesのFalseテスト
 *
 * @return void
 */
	public function testValidateCircularChoicesFalse() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		$data['CircularNoticeContent'] = (new CircularNoticeContentFixture())->records[6];
		$data['CircularNoticeTargetUser'] = (new CircularNoticeTargetUserFixture())->records;
		$data['CircularNoticeChoices'] = (new CircularNoticeChoiceFixture())->records[0];

		$this->_mockForReturnFalse($model, 'CircularNotices.CircularNoticeChoice', 'replaceCircularNoticeChoices');

		//テスト実施
		//$this->_mockForReturnFalse($model, 'CircularNotices.CircularNoticeChoice', 'replaceCircularNoticeChoices');
		$this->$model->$methodName($data);
	}
}
