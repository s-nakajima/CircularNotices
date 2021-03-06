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

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('CircularNoticesAppModel', 'CircularNotices.Model');
App::uses('CircularNoticeTargetUserFixture', 'CircularNotices.Test/Fixture');
App::uses('CircularNoticeContentFixture', 'CircularNotices.Test/Fixture');

/**
 * CircularNoticeTargetUser::saveRead()のテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Model\CircularNoticeTargetUser
 */
class CircularNoticeTargetUserSaveReadTest extends NetCommonsModelTestCase {

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
	public function dataProviderSave() {
		$data['CircularNoticeTargetUser'] = (new CircularNoticeTargetUserFixture())->records[0];
		$data['CircularNoticeContent'] = (new CircularNoticeContentFixture())->records[0];

		$results = array();
		// * 編集の登録処理
		$results[0] = array($data);
		// * 新規の登録処理
		$results[1] = array($data);
		$results[1] = Hash::insert($results[1], '0.CircularNoticeTargetUser.id', null);
		$results[1] = Hash::insert($results[1], '0.CircularNoticeTargetUser.key', null);
		$results[1] = Hash::remove($results[1], '0.CircularNoticeTargetUser.created_user');
	}

/**
 * SaveのExceptionError用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 * //@dataProvider dataProviderSave
 * @return array テストデータ
 */
	public function dataProviderSaveOnExceptionError() {
		$data['CircularNoticeTargetUser'] = (new CircularNoticeTargetUserFixture())->records[0];
		$data['CircularNoticeContent'] = (new CircularNoticeContentFixture())->records[0];
		$results = array();
		// * 編集の登録処理
		$results[0] = array($data);
		// * 新規の登録処理
		$results[1] = array($data);
		$results[1] = Hash::insert($results[1], '0.CircularNoticeTargetUser.id', null);
		$results[1] = Hash::insert($results[1], '0.CircularNoticeTargetUser.key', null);
		$results[1] = Hash::remove($results[1], '0.CircularNoticeTargetUser.created_user');

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
	public function dataProviderSaveOnValidationError() {
		$data = $this->dataProviderSave()[0][0];

		return array(
			array($data, 'CircularNotices.CircularNoticeTargetUser'),
		);
	}

/**
 * SaveRead()の例外テスト
 *
 * @return void
 */
	public function testSaveRead() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$contentId = 7;
		$userId = 5;

		//テスト実施
		$this->$model->$methodName($contentId, $userId);
	}

/**
 * SaveRead()の例外テスト
 *
 * @return void
 */
	public function testSaveReadExceptionError() {
		$this->setExpectedException('InternalErrorException');

		$model = $this->_modelName;
		$methodName = $this->_methodName;

		$contentId = 7;
		$userId = 5;

		// 例外モック
		$thisModelMock = $this->getMockForModel('CircularNotices.' . $model, ['saveCircularNoticeTargetUser']);
		$thisModelMock->expects($this->any())
				->method('saveCircularNoticeTargetUser')
				->will($this->returnValue(false));
		$thisModelMock->$methodName($contentId, $userId);

		$contentId = 8;
		$userId = 6;

		$thisModelMock->$methodName($contentId, $userId);
	}
}
