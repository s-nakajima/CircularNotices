<?php
/**
 * View/Elements/CircularNotices/delete_formのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/CircularNotices/delete_formのテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\View\Elements\CircularNotices\DeleteForm
 */
class CircularNoticesViewElementsCircularNoticesDeleteFormTest extends NetCommonsControllerTestCase {

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
		$this->generateNc('TestCircularNotices.TestViewElementsCircularNoticesDeleteForm');
	}

/**
 * View/Elements/CircularNotices/delete_formのテスト
 *
 * @return void
 */
	public function testDeleteForm() {
		$this->controller->set('circularNoticeContent', array('key' => 'circular_notice_content_1'));

		//テスト実行
		$this->_testGetAction('/test_circular_notices/test_view_elements_circular_notices_delete_form/delete_form',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/CircularNotices/delete_form', '/') . '/';
		$this->assertRegExp($pattern, $this->view);
	}

}
