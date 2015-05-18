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
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
		'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'cerculat notice target users key | 回覧先情報キー | Hash値 | ', 'charset' => 'utf8'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'circular notice target user id | 回覧先 | users.id | '),
		'content_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'circular notice content key | 回覧キー | circular_notice_contents.key | ', 'charset' => 'utf8'),
		'read_flag' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'read flag, 0: not read, 1: read yet | 閲覧フラグ  0:未読、1:既読 |  | '),
		'reply_flag' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'reply flag, 0: not reply, 1: reply yet | 回答フラグ  0:未回答、1:回答 |  | '),
		'reply_text_value' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'circular notice reply value from text | 回覧回答（記述方式） |  | ', 'charset' => 'utf8'),
		'reply_selection_value' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'circular notice reply value from choices | 回覧回答（択一、選択方式） |  | ', 'charset' => 'utf8'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | '),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 |  | '),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 |  | '),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'key' => 'Lorem ipsum dolor sit amet',
			'user_id' => 1,
			'content_key' => 'Lorem ipsum dolor sit amet',
			'read_flag' => 1,
			'reply_flag' => 1,
			'reply_text_value' => 'Lorem ipsum dolor sit amet',
			'reply_selection_value' => 'Lorem ipsum dolor sit amet',
			'created_user' => 1,
			'created' => '2015-03-09 09:25:24',
			'modified_user' => 1,
			'modified' => '2015-03-09 09:25:24'
		),
	);

}
