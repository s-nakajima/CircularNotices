<?php
/**
 * CircularNoticeTargetUserFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * CircularNoticeTargetUserFixture
 */
class CircularNoticeTargetUserFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'user_id' => '4',
			'circular_notice_content_id' => '1',
			'is_read' => false,
			'read_datetime' => '2015-03-09 09:25:24',
			'is_reply' => true,
			'reply_datetime' => '2015-03-09 09:25:24',
			'reply_text_value' => 'Lorem ipsum dolor sit amet',
			'reply_selection_value' => '',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:24',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:24'
		),
		array(
			'id' => '2',
			'user_id' => '4',
			'circular_notice_content_id' => '2',
			'is_read' => true,
			'read_datetime' => '2015-03-09 09:25:24',
			'is_reply' => true,
			'reply_datetime' => '2015-03-09 09:25:24',
			'reply_text_value' => '',
			'reply_selection_value' => '2',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:24',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:24'
		),
		array(
			'id' => '3',
			'user_id' => '4',
			'circular_notice_content_id' => '3',
			'is_read' => true,
			'read_datetime' => '2015-03-09 09:25:24',
			'is_reply' => true,
			'reply_datetime' => '2015-03-09 09:25:24',
			'reply_text_value' => '',
			'reply_selection_value' => '3|5',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:24',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:24'
		),
		array(
			'id' => '4',
			'user_id' => '4',
			'circular_notice_content_id' => '4',
			'is_read' => false,
			'read_datetime' => null,
			'is_reply' => false,
			'reply_datetime' => null,
			'reply_text_value' => '',
			'reply_selection_value' => '3',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:24',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:24'
		),
		array('id' => '5',
			'user_id' => '5',
			'circular_notice_content_id' => '7',
			'is_read' => false,
			'read_datetime' => '2015-03-09 09:25:24',
			'is_reply' => true,
			'reply_datetime' => '2015-03-09 09:25:24',
			'reply_text_value' => 'Lorem ipsum dolor sit amet',
			'reply_selection_value' => '3',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:24',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:24'
		),
		array('id' => '6',
			'user_id' => '6',
			'circular_notice_content_id' => '8',
			'is_read' => false,
			'read_datetime' => '2015-03-09 09:25:24',
			'is_reply' => true,
			'reply_datetime' => '2015-03-09 09:25:24',
			'reply_text_value' => 'Lorem ipsum dolor sit amet',
			'reply_selection_value' => '3',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:24',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:24'
		),
		array('id' => '7',
			'user_id' => '1',
			'circular_notice_content_id' => '1',
			'is_read' => false,
			'read_datetime' => '2015-03-09 09:25:24',
			'is_reply' => true,
			'reply_datetime' => '2015-03-09 09:25:24',
			'reply_text_value' => 'Lorem ipsum dolor sit amet',
			'reply_selection_value' => '1',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:24',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:24'
		),
		array('id' => '8',
			'user_id' => '2',
			'circular_notice_content_id' => '1',
			'is_read' => false,
			'read_datetime' => '2015-03-09 09:25:24',
			'is_reply' => true,
			'reply_datetime' => '2015-03-09 09:25:24',
			'reply_text_value' => 'Lorem ipsum dolor sit amet',
			'reply_selection_value' => '1',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:24',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:24'
		),
		array('id' => '9',
			'user_id' => '2',
			'circular_notice_content_id' => '10',
			'is_read' => false,
			'read_datetime' => '2015-03-09 09:25:24',
			'is_reply' => true,
			'reply_datetime' => '2015-03-09 09:25:24',
			'reply_text_value' => '',
			'reply_selection_value' => '1|3',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:24',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:24'
		),
		array(
			'id' => '10',
			'user_id' => '4',
			'circular_notice_content_id' => '10',
			'is_read' => true,
			'read_datetime' => null,
			'is_reply' => true,
			'reply_datetime' => null,
			'reply_text_value' => 'Lorem ipsum dolor sit amet',
			'reply_selection_value' => '3',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:24',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:24'
		),
		array(
			'id' => '11',
			'user_id' => '4',
			'circular_notice_content_id' => '11',
			'is_read' => false,
			'read_datetime' => '2015-03-09 09:25:24',
			'is_reply' => false,
			'reply_datetime' => '2015-03-09 09:25:24',
			'reply_text_value' => 'Lorem ipsum dolor sit amet',
			'reply_selection_value' => '6',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:24',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:24'
		),
		array(
			'id' => '12',
			'user_id' => '4',
			'circular_notice_content_id' => '12',
			'is_read' => false,
			'read_datetime' => '2015-03-09 09:25:24',
			'is_reply' => true,
			'reply_datetime' => '2015-03-09 09:25:24',
			'reply_text_value' => 'Lorem ipsum dolor sit amet',
			'reply_selection_value' => '7',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:24',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:24'
		),
		array(
			'id' => '13',
			'user_id' => '1',
			'circular_notice_content_id' => '14',
			'is_read' => false,
			'read_datetime' => '2015-03-09 09:25:24',
			'is_reply' => true,
			'reply_datetime' => '2015-03-09 09:25:24',
			'reply_text_value' => 'Lorem ipsum dolor sit amet',
			'reply_selection_value' => '',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:24',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:24'
		),
		array(
			'id' => '14',
			'user_id' => '2',
			'circular_notice_content_id' => '14',
			'is_read' => false,
			'read_datetime' => '2015-03-09 09:25:24',
			'is_reply' => true,
			'reply_datetime' => '2015-03-09 09:25:24',
			'reply_text_value' => 'Lorem ipsum dolor sit amet',
			'reply_selection_value' => '',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:24',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:24'
		),
		array(
			'id' => '15',
			'user_id' => '4',
			'circular_notice_content_id' => '14',
			'is_read' => false,
			'read_datetime' => '2015-03-09 09:25:24',
			'is_reply' => true,
			'reply_datetime' => '2015-03-09 09:25:24',
			'reply_text_value' => 'Lorem ipsum dolor sit amet',
			'reply_selection_value' => '',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:24',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:24'
		),
		array(
			'id' => '16',
			'user_id' => '5',
			'circular_notice_content_id' => '14',
			'is_read' => false,
			'read_datetime' => '2015-03-09 09:25:24',
			'is_reply' => true,
			'reply_datetime' => '2015-03-09 09:25:24',
			'reply_text_value' => 'Lorem ipsum dolor sit amet',
			'reply_selection_value' => '',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:24',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:24'
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('CircularNotices') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new CircularNoticesSchema())->tables[Inflector::tableize($this->name)];
		parent::init();
	}

}
