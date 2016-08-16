<?php
/**
 * CircularNoticeContent::getCircularNoticeContentsForPaginate()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsGetTest', 'NetCommons.TestSuite');

/**
 * CircularNoticeContent::getCircularNoticeContentsForPaginate()のテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Model\CircularNoticeContent
 */
class CircularNoticeContentGetCircularNoticeContentsForPaginateTest extends NetCommonsGetTest {

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
	protected $_methodName = 'getCircularNoticeContentsForPaginate';

/**
 * testPaginatorParamsCheckのDataProvider
 *
 * ### 戻り値
 *  - blockKey CircularNoticeContentのblock_key
 *  - user_id ユーザID
 *  - paginatorParams paginatorで使用するパラメータ
 *  - defaultLimit データ取得件数のデフォルト値
 *
 * @return array
 */
	public function dataProviderPaginatorParamsCheck() {
		return array(
			array(
				'blockKey' => null,
				'userId' => null,
				'paginatorParams' => array(
					'reply_status' => 10,
				),
				'defaultLimit' => null,
			),
			array(
				'blockKey' => null,
				'userId' => null,
				'paginatorParams' => array(
					'reply_status' => 11,
				),
				'defaultLimit' => null,
			),
			array(
				'blockKey' => null,
				'userId' => null,
				'paginatorParams' => array(
					'reply_status' => 12,
				),
				'defaultLimit' => null,
			),
			array(
				'blockKey' => null,
				'userId' => null,
				'paginatorParams' => array(
					'reply_status' => 13,
				),
				'defaultLimit' => null,
			),
			array(
				'blockKey' => null,
				'userId' => null,
				'paginatorParams' => array(
					'content_status' => 2,
				),
				'defaultLimit' => null,
			),
			array(
				'blockKey' => null,
				'userId' => null,
				'paginatorParams' => array(
					'sort' => 'CircularNoticeContent.subject',
					'direction' => 'desc',
				),
				'defaultLimit' => null,
			),
			array(
				'blockKey' => null,
				'userId' => null,
				'paginatorParams' => array(
					'limit' => '5',
				),
				'defaultLimit' => null,
			),
		);
	}

/**
 * getCircularNoticeContentsForPaginate()のテスト
 *
 * @return void
 */
	public function testGetCircularNoticeContentsForPaginate() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		$blockKey = null;
		$userId = null;
		$paginatorParams = null;
		$defaultLimit = null;

		//テスト実施
		$result = $this->$model->$methodName($blockKey, $userId, $paginatorParams, $defaultLimit);

		//チェック
		$this->assertNotEmpty($result);
	}

/**
 * PaginatorParams()のCheckテスト
 *
 * @param $blockKey
 * @param $userId
 * @param $paginatorParams
 * @param $defaultLimit
 * @dataProvider dataProviderPaginatorParamsCheck
 * @return void
 */
	public function testPaginatorParamsCheck($blockKey, $userId, $paginatorParams, $defaultLimit) {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//テスト実施
		$result = $this->$model->$methodName($blockKey, $userId, $paginatorParams, $defaultLimit);

		//チェック
		$this->assertTrue(is_array($result));
	}
}
