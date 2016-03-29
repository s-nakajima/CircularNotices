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
		return array(
			array($data[0]['key'], 'CircularNotices.CircularNoticeContent', 'deleteAll'),
		);
	}

	/**
	// * ExceptionError
	 *
	 * @return void
	 */
	public function testCircularNoticeTargetUserDeleteExceptionError() {

		$key = 'frame_4';
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$this->setExpectedException('InternalErrorException');

		$this->_mockForReturnFalse($model, 'CircularNoticeTargetUser', 'deleteAll');
		$this->$model->$methodName($key);
	}

	/**
	// * ExceptionError
	 *
	 * @return void
	 */
	public function testCircularNoticeChoiceDeleteExceptionError() {

		$key = 'frame_4';
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$this->setExpectedException('InternalErrorException');

		$this->_mockForReturnFalse($model, 'CircularNoticeChoice', 'deleteAll');
		$this->$model->$methodName($key);
	}
	
	/**
// * ExceptionError
 *
 * @return void
 */
	public function testCircularNoticeContentDeleteExceptionError() {
		
		$key = 'frame_5';
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$this->setExpectedException('InternalErrorException');

		$circularNoticeChoicesMock = $this->getMockForModel('CircularNotices.'.$model, ['delete']);
		$circularNoticeChoicesMock->expects($this->any())
				->method('delete')
				->will($this->returnValue(false));
		$circularNoticeChoicesMock->$methodName($key);
		
	}

}
