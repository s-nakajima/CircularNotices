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

App::uses('NetCommonsSaveTest', 'NetCommons.TestSuite');
App::uses('CircularNoticeContentFixture', 'CircularNotices.Test/Fixture');
App::uses('CircularNoticeTargetUserFixture', 'CircularNotices.Test/Fixture');
App::uses('CircularNoticeChoiceFixture', 'CircularNotices.Test/Fixture');


/**
 * CircularNoticeContent::saveCircularNoticeContent()のテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Model\CircularNoticeContent
 */
class CircularNoticeContentSaveCircularNoticeContentTest extends NetCommonsSaveTest {

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
	protected $_methodName = 'saveCircularNoticeContent';

/**
 * Save用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *
 * @return array テストデータ
 */
	public function dataProviderSave() {
		$data['CircularNoticeContent'] = (new CircularNoticeContentFixture())->records[0];

		//TODO:テストパタンを書く
		$results = array();
		// * 編集の登録処理
		$results[0] = array($data);
		// * 新規の登録処理
		$results[1] = array($data);
		$results[1] = Hash::insert($results[1], '0.CircularNoticeContent.id', null);
		$results[1] = Hash::insert($results[1], '0.CircularNoticeContent.key', null); //TODO:不要なら削除する
		$results[1] = Hash::remove($results[1], '0.CircularNoticeContent.created_user');

		return $results;
	}

/**
 * SaveのExceptionError用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return array テストデータ
 */
	public function dataProviderSaveOnExceptionError() {
		$data = $this->dataProviderSave()[0][0];

		//TODO:テストパタンを書く
		return array(
			array($data, 'CircularNotices.CircularNoticeContent', 'save'),
		);
	}

/**
// * SaveのValidationError用DataProvider
 *
// * ### 戻り値
// *  - data 登録データ
// *  - mockModel Mockのモデル
// *  - mockMethod Mockのメソッド(省略可：デフォルト validates)
 *
// * @return array テストデータ
 * @return void
 */
	public function testSaveCircularNoticeContentFalse() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		
		$data['CircularNoticeContent'] = (new CircularNoticeContentFixture())->records[1];
		$data['CircularNoticeTargetUser'] = (new CircularNoticeTargetUserFixture())->records[0];
		$data['CircularNoticeChoices'] =  (new CircularNoticeChoiceFixture())->records[0];
		
		//テスト実施
		$result = $this->$model->$methodName($data);

		//TODO:テストパタンを書く
//		return array(
//			array($data, 'CircularNotices.CircularNoticeContent'),
//		);
	}
	
	/**
	// * SaveのValidationError用DataProvider
	 *
	// * ### 戻り値
	// *  - data 登録データ
	// *  - mockModel Mockのモデル
	// *  - mockMethod Mockのメソッド(省略可：デフォルト validates)
	 *
	// * @return array テストデータ
	 * @return void
	 */
	public function testSaveCircularNoticeContent() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		$data['CircularNoticeContent'] = (new CircularNoticeContentFixture())->records[0];
		$data['CircularNoticeTargetUser'] = (new CircularNoticeTargetUserFixture())->records;
		$data['CircularNoticeChoices'] =  (new CircularNoticeChoiceFixture())->records[0];

		//テスト実施
		$result = $this->$model->$methodName($data);

		//TODO:テストパタンを書く
//		return array(
//			array($data, 'CircularNotices.CircularNoticeContent'),
//		);
	}

	/**
	// * Saveの例外テスト
	 *
	// * ### 戻り値
	// *  - data 登録データ
	// *  - mockModel Mockのモデル
	// *  - mockMethod Mockのメソッド(省略可：デフォルト validates)
	 *
	// * @return array テストデータ
	 * @return void
	 */
	public function testSaveCircularNoticeContentException() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
//		$this->setExpectedException('InternalErrorException');

		$data['CircularNoticeContent'] = (new CircularNoticeContentFixture())->records;
		$data['CircularNoticeTargetUser'] = (new CircularNoticeTargetUserFixture())->records;
		$data['CircularNoticeChoices'] =  (new CircularNoticeChoiceFixture())->records;




//			$content = $this->createAll(array(
//					'Block' => array(
//							'room_id' => 5,
//					),
//			));
//			$content = Hash::merge($content, $this->CircularNoticeContent->create());


		// 例外を発生させるためのモック
		$circularCircularNoticeContentMock = $this->getMockForModel('CircularNotices.' . $model, ['__saveChoiceAndTargetUsers']);
		$circularCircularNoticeContentMock->expects($this->any())
				->method('__saveChoiceAndTargetUsers')
				->will($this->returnValue(false));

//		$circularCircularNoticeContentMock->create(array(
//				'Block' => array(
//						'room_id' => 5,
//				),
//		));
		//テスト実施
		$result = $circularCircularNoticeContentMock->$methodName($data);

		//TODO:テストパタンを書く
//		return array(
//			array($data, 'CircularNotices.CircularNoticeContent'),
//		);
	}
}
