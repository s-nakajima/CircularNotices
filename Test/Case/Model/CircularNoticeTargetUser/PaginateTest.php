<?php
/**
 * CircularNoticeTargetUser::paginate()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * CircularNoticeTargetUser::paginate()のテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Model\CircularNoticeTargetUser
 */
class CircularNoticeTargetUserPaginateTest extends NetCommonsModelTestCase {

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
	protected $_methodName = 'paginate';

/**
 * paginate()のテスト
 *
 * @return void
 */
	public function testPaginate() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		$conditions = null;
		$fields = null;
		$order = array('user_id' => 'asc');
		$limit = null;
		$page = 1;
		$recursive = null;
		$extra = array();

		//テスト実施
		$this->$model->virtualFields['first_order'] = 'CASE WHEN CircularNoticeTargetUser.user_id = 1 THEN 1 ELSE 2 END';
		$this->$model->$methodName($conditions, $fields, $order, $limit, $page, $recursive, $extra);
	}

}
