<?php
/**
 * CircularNoticesController::__parseRequestForSave()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');
App::uses('CircularNoticesController', 'CircularNotices.Controller');

/**
 * CircularNoticesController::__parseAnswer()のテスト
 *
 * @author Ryohei Ohga <ohga.ryohei@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Controller\CircularNoticesController
 */
class CircularNoticesControllerParseAnswerTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

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
	protected $_controller = 'circular_notices';

/**
 * __parseAnswerメソッドのテスト用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderParseAnswer() {
		//テストデータ
		$results = array();
		$results[1] = array(
			'data' => array(
				'CircularNoticeContent' => array(
					'reply_type' => '1',
				),
				'CircularNoticeTargetUser' => array(
					'CircularNoticeTargetUser' => array(
						'reply_text_value' => 'Lorem ipsum dolor sit amet'
					),
				),
			),
			'assert' => 'Lorem ipsum dolor sit amet'
		);
		$results[2] = array(
			'data' => array(
				'CircularNoticeContent' => array(
					'reply_type' => '2',
				),
				'CircularNoticeTargetUser' => array(
					'CircularNoticeTargetUser' => array(
						'reply_selection_value' => '1|3',
					),
				),
			),
			'assert' => '1、3'
		);

		return $results;
	}

/**
 * __parseAnswerアクションのテスト(ログインなし)
 *
 * @param $data
 * @param string $assert
 * @param null $exception
 * @dataProvider dataProviderParseAnswer
 */
	public function testParseAnswer($data, $assert, $exception = null) {
		//テスト実施
		$stub = $this->getMockBuilder('CircularNoticesControllerParseAnswerMock')
			->setMethods(null)
			->getMock();
		$method = new ReflectionMethod($stub, '__parseAnswer');
		$method->setAccessible(true);
		$result = $method->invoke(
			$stub,
			$data['CircularNoticeContent']['reply_type'],
			$data['CircularNoticeTargetUser']
		);
		$this->assertEquals($result, $assert);
	}
}
/**
 * CircularNoticesControllerParseAnswerMock
 *
 * @author Ryohei Ohga <ohga.ryohei@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Controller\CircularNoticesController
 */
class CircularNoticesControllerParseAnswerMock extends CircularNoticesController {

/**
 * data property
 *
 * @var array
 */
	public $data;
}