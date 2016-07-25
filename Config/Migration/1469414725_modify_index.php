<?php
/**
 * ModifyIndex CakeMigration
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2016, NetCommons Project
 */

/**
 * ModifyIndex CakeMigration
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Config\Migration
 */
class ModifyIndex extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'modify_index';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'alter_field' => array(
				'circular_notice_choices' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID |  |  | '),
					'circular_notice_content_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index', 'comment' => 'circular notice content id | 回覧ID | circular_notice_contents.id | '),
					'weight' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'circular notice\'s choice value\'s weight | 選択肢表示順 |  | '),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => 'created user | 作成者 | users.id | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => 'modified user | 更新者 | users.id | '),
				),
				'circular_notice_contents' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID |  |  | '),
					'reply_type' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1, 'unsigned' => false, 'comment' => 'reply type. 1:text field , 2:selection, 3:multiple selection | 回答方式  1:記述方式、2:択一方式、3:選択方式 |  | '),
					'status' => array('type' => 'integer', 'null' => false, 'default' => '3', 'length' => 4, 'unsigned' => false, 'comment' => 'status, 1: public, 3: draft during | 公開状況  1:公開中3:下書き中、 |  | '),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => 'created user | 作成者 | users.id | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => 'modified user | 更新者 | users.id | '),
				),
				'circular_notice_frame_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID |  |  | '),
					'display_number' => array('type' => 'integer', 'null' => false, 'default' => '10', 'unsigned' => false, 'comment' => 'visible post row, 1 post or 5, 10, 20, 50, 100 posts | 表示回覧数 1件、5件、10件、20件、50件、100件 |  | '),
					'created_user' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'comment' => 'created user | 作成者 | users.id | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => 'modified user | 更新者 | users.id | '),
				),
				'circular_notice_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID |  |  | '),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => 'created user | 作成者 | users.id | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => 'modified user | 更新者 | users.id | '),
				),
				'circular_notice_target_users' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID |  |  | '),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'comment' => 'circular notice target user id | 回覧先 | users.id | '),
					'circular_notice_content_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index', 'comment' => 'circular notice content id | 回覧ID | circular_notice_contents.id | '),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => 'created user | 作成者 | users.id | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => 'modified user | 更新者 | users.id | '),
				),
			),
			'drop_field' => array(
				'circular_notice_choices' => array('indexes' => array('fk_circular_notice_target_users_circular_notice_contents1_idx')),
				'circular_notice_contents' => array('indexes' => array('circular_notice_contents_key1', 'fk_circular_notice_contentscircular_notices1')),
				'circular_notice_frame_settings' => array('indexes' => array('fk_circular_notice_frame_settings_frames1')),
				'circular_notice_settings' => array('indexes' => array('circular_notices_key1', 'fk_circular_notices_blocks1')),
				'circular_notice_target_users' => array('indexes' => array('fk_circular_notice_target_users_circular_notice_contents1_idx', 'fk_circular_notice_target_users_users1')),
			),
			'create_field' => array(
				'circular_notice_choices' => array(
					'indexes' => array(
						'circular_notice_content_id' => array('column' => array('circular_notice_content_id', 'weight'), 'unique' => 0),
					),
				),
				'circular_notice_contents' => array(
					'indexes' => array(
						'key' => array('column' => 'key', 'unique' => 0),
						'circular_notice_setting_key' => array('column' => 'circular_notice_setting_key', 'unique' => 0),
					),
				),
				'circular_notice_frame_settings' => array(
					'indexes' => array(
						'frame_key' => array('column' => 'frame_key', 'unique' => 0),
					),
				),
				'circular_notice_settings' => array(
					'indexes' => array(
						'block_key' => array('column' => 'block_key', 'unique' => 0),
					),
				),
				'circular_notice_target_users' => array(
					'indexes' => array(
						'circular_notice_content_id' => array('column' => array('circular_notice_content_id', 'read_flag'), 'unique' => 0),
						'circular_notice_content_id_2' => array('column' => array('circular_notice_content_id', 'user_id'), 'unique' => 0),
					),
				),
			),
		),
		'down' => array(
			'alter_field' => array(
				'circular_notice_choices' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
					'circular_notice_content_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => 'circular notice content id | 回覧ID | circular_notice_contents.id | '),
					'weight' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'circular notice\'s choice value\'s weight | 選択肢表示順 |  | '),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
				),
				'circular_notice_contents' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
					'reply_type' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1, 'comment' => 'reply type. 1:text field , 2:selection, 3:multiple selection | 回答方式  1:記述方式、2:択一方式、3:選択方式 |  | '),
					'status' => array('type' => 'integer', 'null' => false, 'default' => '3', 'length' => 1, 'comment' => 'status, 1: public, 3: draft during | 公開状況  1:公開中3:下書き中、 |  | '),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
				),
				'circular_notice_frame_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
					'display_number' => array('type' => 'integer', 'null' => false, 'default' => '10', 'comment' => 'visible post row, 1 post or 5, 10, 20, 50, 100 posts | 表示回覧数 1件、5件、10件、20件、50件、100件 |  | '),
					'created_user' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'created user | 作成者 | users.id | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
				),
				'circular_notice_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
				),
				'circular_notice_target_users' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => 'circular notice target user id | 回覧先 | users.id | '),
					'circular_notice_content_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => 'circular notice content id | 回覧ID | circular_notice_contents.id | '),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
				),
			),
			'create_field' => array(
				'circular_notice_choices' => array(
					'indexes' => array(
						'fk_circular_notice_target_users_circular_notice_contents1_idx' => array('column' => 'circular_notice_content_id', 'unique' => 0),
					),
				),
				'circular_notice_contents' => array(
					'indexes' => array(
						'circular_notice_contents_key1' => array('column' => 'key', 'unique' => 0),
						'fk_circular_notice_contentscircular_notices1' => array('column' => 'circular_notice_setting_key', 'unique' => 0),
					),
				),
				'circular_notice_frame_settings' => array(
					'indexes' => array(
						'fk_circular_notice_frame_settings_frames1' => array('column' => 'frame_key', 'unique' => 0),
					),
				),
				'circular_notice_settings' => array(
					'indexes' => array(
						'circular_notices_key1' => array('column' => 'key', 'unique' => 0),
						'fk_circular_notices_blocks1' => array('column' => 'block_key', 'unique' => 0),
					),
				),
				'circular_notice_target_users' => array(
					'indexes' => array(
						'fk_circular_notice_target_users_circular_notice_contents1_idx' => array('column' => 'circular_notice_content_id', 'unique' => 0),
						'fk_circular_notice_target_users_users1' => array('column' => 'user_id', 'unique' => 0),
					),
				),
			),
			'drop_field' => array(
				'circular_notice_choices' => array('indexes' => array('circular_notice_content_id')),
				'circular_notice_contents' => array('indexes' => array('key', 'circular_notice_setting_key')),
				'circular_notice_frame_settings' => array('indexes' => array('frame_key')),
				'circular_notice_settings' => array('indexes' => array('block_key')),
				'circular_notice_target_users' => array('indexes' => array('circular_notice_content_id', 'circular_notice_content_id_2')),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
