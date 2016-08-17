<?php
/**
 * View/Elements/CircularNotices/select_sortのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/CircularNotices/select_sortのテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\View\Elements\CircularNotices\SelectSort
 */
class CircularNoticesViewElementsCircularNoticesSelectSortTest extends NetCommonsControllerTestCase {

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
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'CircularNotices', 'TestCircularNotices');
		//テストコントローラ生成
		$this->generateNc('TestCircularNotices.TestViewElementsCircularNoticesSelectSort');
	}

/**
 * View/Elements/CircularNotices/select_sortのテスト
 *
 * @return void
 */
	public function testSelectSort() {
		$this->controller->set('currentSort', 'CircularNoticeContent.modified');
		$this->controller->set('currentDirection', 'desc');
		$this->controller->set('sortOptions', array(
			'CircularNoticeContent.modified.desc' => array(
				'label' => __d('net_commons', 'Newest'),
				'sort' => 'CircularNoticeContent.modified',
				'direction' => 'desc'
			),
			'CircularNoticeContent.created.asc' => array(
				'label' => __d('net_commons', 'Oldest'),
				'sort' => 'CircularNoticeContent.created',
				'direction' => 'asc'
			),
			'CircularNoticeContent.subject.asc' => array(
				'label' => __d('net_commons', 'Title'),
				'sort' => 'CircularNoticeContent.subject',
				'direction' => 'asc'
			),
			'CircularNoticeContent.reply_deadline.desc' => array(
				'label' => __d('circular_notices', 'Change Sort Order to Reply Deadline'),
				'sort' => 'CircularNoticeContent.reply_deadline',
				'direction' => 'desc'
			))
		);

		//テスト実行
		$this->_testGetAction('/test_circular_notices/test_view_elements_circular_notices_select_sort/select_sort',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/CircularNotices/select_sort', '/') . '/';
		$this->assertRegExp($pattern, $this->view);
	}
}
