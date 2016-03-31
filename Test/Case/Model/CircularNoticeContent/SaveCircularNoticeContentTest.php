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
class CircularNoticeContentSaveCircularNoticeContentTest extends NetCommonsModelTestCase
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
    protected $_modelName = 'CircularNoticeContent';

    /**
     * Method name
     *
     * @var string
     */
    protected $_methodName = 'saveCircularNoticeContent';

    public function setUp()
    {
        parent::setUp();
        Current::$current['Room']['id'] = '1';
    }

    /**
     * SaveCircularNoticeContentのテスト
     *
     * @return void
     */
    public function testSaveCircularNoticeContent()
    {
        $model = $this->_modelName;
        $methodName = $this->_methodName;

        $data['CircularNoticeContent'] = (new CircularNoticeContentFixture())->records[8];
        $data['CircularNoticeTargetUser'] = (new CircularNoticeTargetUserFixture())->records;
        $data['CircularNoticeChoices'] =  (new CircularNoticeChoiceFixture())->records[0];

        //テスト実施
        $result = $this->$model->$methodName($data);
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
		$data['CircularNoticeChoices'] =  (new CircularNoticeChoiceFixture())->records[0];
		
		//テスト実施
		$result = $this->$model->$methodName($data);
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
		$data['CircularNoticeChoices'] =  (new CircularNoticeChoiceFixture())->records[0];

		$this->_mockForReturnFalse($model, 'CircularNotices.CircularNoticeChoice', 'validateCircularChoices');
		//テスト実施
		$result = $this->$model->$methodName($data);
	}

	/**
	 * SaveCircularNoticeContentの例外テスト
	 *
	 *
	 * @return void
	 */
	public function testSaveCircularNoticeContentException() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$this->setExpectedException('InternalErrorException');

		$data['CircularNoticeContent'] = (new CircularNoticeContentFixture())->records[6];
		$data['CircularNoticeTargetUser'] = (new CircularNoticeTargetUserFixture())->records;
		$data['CircularNoticeChoices'] =  (new CircularNoticeChoiceFixture())->records[0];


		// 例外を発生させるためのモック
		$circularCircularNoticeContentMock = $this->getMockForModel('CircularNotices.' . $model, ['save']);
		$circularCircularNoticeContentMock->expects($this->any())
				->method('save')
				->will($this->returnValue(false));

		//テスト実施
		$result = $circularCircularNoticeContentMock->$methodName($data);
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
		$data['CircularNoticeChoices'] =  (new CircularNoticeChoiceFixture())->records[0];

		$this->_mockForReturnFalse($model, 'CircularNotices.CircularNoticeChoice', 'replaceCircularNoticeChoices');

		//テスト実施
		$this->$model->$methodName($data);
	}
}
