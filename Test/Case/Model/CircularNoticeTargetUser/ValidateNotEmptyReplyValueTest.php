<?php
/**
 * CircularNoticeTargetUser::validateNotEmptyReplyValue()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * CircularNoticeTargetUser::validateNotEmptyReplyValue()のテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Model\CircularNoticeTargetUser
 */
class CircularNoticeTargetUserValidateNotEmptyReplyValueTest extends NetCommonsModelTestCase {

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
	protected $_methodName = 'validateNotEmptyReplyValue';

/**
 * validateNotEmptyReplyValue()のテスト
 *
 * @return void
 */
	public function testValidateNotEmptyReplyValue() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$check = 'fields';

		//データ生成
		$this->$model->data['CircularNoticeTargetUser'] = array();
		$this->$model->data['CircularNoticeTargetUser']['reply_text_value'] = null;
		$this->$model->data['CircularNoticeTargetUser']['reply_selection_value'] = null;

		//テスト実施
		$result = $this->$model->$methodName($check);

		//チェック

		$this->$model->data['CircularNoticeTargetUser']['reply_text_value'] = true;
		$this->$model->data['CircularNoticeTargetUser']['reply_selection_value'] = true;
		//テスト実施
		$result = $this->$model->$methodName($check);

		//チェック
	}
}
