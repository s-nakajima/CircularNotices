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
		'plugin.site_manager.site_setting',
		'plugin.users.user',
		'plugin.mails.mail_setting',
		'plugin.mails.mail_queue',
		'plugin.mails.mail_queue_user',
		'plugin.circular_notices.circular_notice_choice',
		'plugin.circular_notices.circular_notice_content',
		'plugin.circular_notices.circular_notice_frame_setting',
		'plugin.circular_notices.circular_notice_setting',
		'plugin.circular_notices.circular_notice_target_user',
		'plugin.user_attributes.user_attribute_layout',
		'plugin.frames.frame',
		'plugin.blocks.block',
		'plugin.rooms.room_role',
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

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		Current::$current['Room']['id'] = '1';
	}

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
		$result = $this->$model->$methodName($data);
		$this->assertFalse($result);
	}

/**
 * SaveCircularNoticeContentのFalseテスト
 *
 * @return void
 */
	public function testSaveCircularNoticeContentFalse() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$data['CircularNoticeContent'] = (new CircularNoticeContentFixture())->records[8];
		$data['CircularNoticeTargetUser'] = (new CircularNoticeTargetUserFixture())->records[0];
		$data['CircularNoticeChoices'] = [(new CircularNoticeChoiceFixture())->records[0]];
		//テスト実施
		$result = $this->$model->$methodName($data);
		$this->assertFalse($result);
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
		$data['CircularNoticeContent'] = (new CircularNoticeContentFixture())->records[8];
		$data['CircularNoticeTargetUser'] = (new CircularNoticeTargetUserFixture())->records;
		$data['CircularNoticeChoices'] = [(new CircularNoticeChoiceFixture())->records[0]];
		$this->_mockForReturnFalse($model, 'CircularNotices.CircularNoticeChoice', 'validateCircularChoices');
		//テスト実施
		$result = $this->$model->$methodName($data);
		$this->assertFalse($result);
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
 * SaveCircularNoticeChoiceの例外テスト
 *
 * @return void
 */
	public function testSaveCircularNoticeChoiceFalse() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$data['CircularNoticeContent'] = (new CircularNoticeContentFixture())->records[6];
		$data['CircularNoticeTargetUsers'][0]['CircularNoticeTargetUser'] = (new CircularNoticeTargetUserFixture())->records[0];
		$data['CircularNoticeChoices'][0]['CircularNoticeChoice'] = (new CircularNoticeChoiceFixture())->records[0];
		// 例外を発生させるためのモック
		$thisModelMock = $this->getMockForModel('CircularNotices.' . $model, ['save']);
		$thisModelMock->expects($this->any())
				->method('save')
				->will($this->returnValue(true));
		//テスト実施
		$this->_mockForReturnFalse($model, 'CircularNoticeChoice', 'replaceCircularNoticeChoices');
		$result = $thisModelMock->$methodName($data);
		$this->assertFalse($result);
	}

/**
 * SaveCircularNoticeTargetUserの例外テスト
 *
 * @return void
 */
	public function testSaveCircularNoticeTargetUserFalse() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$data['CircularNoticeContent'] = (new CircularNoticeContentFixture())->records[6];
		$data['CircularNoticeTargetUsers'][0]['CircularNoticeTargetUser'] = (new CircularNoticeTargetUserFixture())->records[0];
		$data['CircularNoticeChoices'][0]['CircularNoticeChoice'] = (new CircularNoticeChoiceFixture())->records[0];
		$expectedContent = array(
			'CircularNoticeContent' => (new CircularNoticeContentFixture())->records[6],
		);
		// 例外を発生させるためのモック
		$thisModelMock = $this->getMockForModel('CircularNotices.' . $model, ['save']);
		$thisModelMock->expects($this->any())
				->method('save')
				->will($this->returnValue($expectedContent));
		//テスト実施
		$this->_mockForReturnFalse($model, 'CircularNoticeTargetUser', 'replaceCircularNoticeTargetUsers');
		$result = $thisModelMock->$methodName($data);
		$this->assertFalse($result);
	}

/**
 * SaveCircularNoticeGroupOnlyMailの例外テスト
 *
 * @return void
 */
	public function testSaveCircularNoticeGroupOnlyMail() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$data['CircularNoticeContent'] = (new CircularNoticeContentFixture())->records[6];
		$data['CircularNoticeContent']['publish_start'] = date('Y-m-d H:i:s', strtotime('+3 minute'));
		$data['CircularNoticeTargetUsers'][0]['CircularNoticeTargetUser'] = (new CircularNoticeTargetUserFixture())->records[0];
		$data['CircularNoticeChoices'][0]['CircularNoticeChoice'] = (new CircularNoticeChoiceFixture())->records[0];

		$expectedContent = array(
				'CircularNoticeContent' => (new CircularNoticeContentFixture())->records[6],
		);
		// 例外を発生させるためのモック
		$thisModelMock = $this->getMockForModel('CircularNotices.' . $model, ['save']);
		$thisModelMock->expects($this->any())
				->method('save')
				->will($this->returnValue($expectedContent));
		//テスト実施
		$this->_mockForReturnFalse($model, 'CircularNoticeTargetUser', 'replaceCircularNoticeTargetUsers');
		$result = $thisModelMock->$methodName($data);
		$this->assertFalse($result);
	}
}