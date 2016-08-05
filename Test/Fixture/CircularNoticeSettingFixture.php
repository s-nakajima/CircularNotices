<?php
/**
 * CircularNoticeSettingFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * CircularNoticeSettingFixture
 */
class CircularNoticeSettingFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
		'block_key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'block key | ブロックKey | blocks.key | ', 'charset' => 'utf8'),
		'key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'circular notice settings key | 回覧板キー | Hash値 | ', 'charset' => 'utf8'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | '),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 |  | '),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 |  | '),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'circular_notices_key1' => array('column' => 'key', 'unique' => 0),
			'fk_circular_notices_blocks1' => array('column' => 'block_key', 'unique' => 0)
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
			'id' => '1',
			'block_key' => 'block_1',
			'key' => 'circular_notice_setting_1',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:26',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:27'
		),
		array(
			'id' => '2',
			'block_key' => 'block_1',
			'key' => 'circular_notice_setting_2',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:26',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:27'
		),
		array(
			'id' => '3',
			'block_key' => 'block_1',
			'key' => 'circular_notice_3',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:26',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:27'
		),
		array(
			'id' => '4',
			'block_key' => 'block_1',
			'key' => 'circular_notice_4',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:26',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:27'
		),
	);
}
