<?php
class ChangeTableNameAndColumns extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'change_table_name_and_columns';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
				'circular_notice_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
					'block_key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'block key | ブロックKey | blocks.key | ', 'charset' => 'utf8'),
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'circular notice settings key | 回覧板キー | Hash値 | ', 'charset' => 'utf8'),
					'posts_authority' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'posts authority. 0:general cannot post, 1:general can post | 投稿権限 0:一般は投稿できない, 1:一般は投稿できる  |  |'),
					'mail_notice_flag' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'flag for notice via mail when circular notice is opened. 0:do not send, 1:send | メール通知フラグ 0:通知しない, 1:通知する  |  |'),
					'mail_subject' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'mail subject | メール件名 |  | ', 'charset' => 'utf8'),
					'mail_body' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'mail body | メール本文 |  | ', 'charset' => 'utf8'),
					'is_auto_translated' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'translation type. 0:original , 1:auto translation | 翻訳タイプ  0:オリジナル、1:自動翻訳 |  | '),
					'translation_engine' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'translation engine | 翻訳エンジン |  | ', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | '),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 |  | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 |  | '),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'circular_notices_key1' => array('column' => 'key', 'unique' => 0),
						'fk_circular_notices_blocks1' => array('column' => 'block_key', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			),
			'alter_field' => array(
				'circular_notice_choices' => array(
					'circular_notice_content_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => 'circular notice content id | 回覧ID | circular_notice_contents.id | '),
				),
				'circular_notice_contents' => array(
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'circulat notice content key | 回覧キー | Hash値 | ', 'charset' => 'utf8'),
				),
				'circular_notice_frame_settings' => array(
					'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'frame key | フレームKey | frames.key | ', 'charset' => 'utf8'),
				),
				'circular_notice_target_users' => array(
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => 'circular notice target user id | 回覧先 | users.id | '),
					'circular_notice_content_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => 'circular notice content id | 回覧ID | circular_notice_contents.id | '),
				),
			),
			'create_field' => array(
				'circular_notice_choices' => array(
					'indexes' => array(
						'fk_circular_notice_target_users_circular_notice_contents1_idx' => array('column' => 'circular_notice_content_id', 'unique' => 0),
					),
				),
				'circular_notice_contents' => array(
					'circular_notice_setting_key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'circular notice setting key | 回覧板キー | circular_notice_settings.key | ', 'charset' => 'utf8', 'after' => 'key'),
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
				'circular_notice_target_users' => array(
					'indexes' => array(
						'fk_circular_notice_target_users_circular_notice_contents1_idx' => array('column' => 'circular_notice_content_id', 'unique' => 0),
						'fk_circular_notice_target_users_users1' => array('column' => 'user_id', 'unique' => 0),
					),
				),
			),
			'drop_field' => array(
				'circular_notice_contents' => array('circular_notice_key', 'status'),
			),
			'drop_table' => array(
				'circular_notices'
			),
		),
		'down' => array(
			'drop_table' => array(
				'circular_notice_settings'
			),
			'alter_field' => array(
				'circular_notice_choices' => array(
					'circular_notice_content_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'circular notice content id | 回覧ID | circular_notice_contents.id | '),
				),
				'circular_notice_contents' => array(
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'cerculat notice content key | 回覧キー | Hash値 | ', 'charset' => 'utf8'),
				),
				'circular_notice_frame_settings' => array(
					'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'frame key | フレームKey | frames.key | ', 'charset' => 'utf8'),
				),
				'circular_notice_target_users' => array(
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'circular notice target user id | 回覧先 | users.id | '),
					'circular_notice_content_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'circular notice content id | 回覧ID | circular_notice_contents.id | '),
				),
			),
			'drop_field' => array(
				'circular_notice_choices' => array('indexes' => array('fk_circular_notice_target_users_circular_notice_contents1_idx')),
				'circular_notice_contents' => array('circular_notice_setting_key', 'indexes' => array('circular_notice_contents_key1', 'fk_circular_notice_contentscircular_notices1')),
				'circular_notice_frame_settings' => array('indexes' => array('fk_circular_notice_frame_settings_frames1')),
				'circular_notice_target_users' => array('indexes' => array('fk_circular_notice_target_users_circular_notice_contents1_idx', 'fk_circular_notice_target_users_users1')),
			),
			'create_field' => array(
				'circular_notice_contents' => array(
					'circular_notice_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'circular notice key | 回覧板キー | circular_notices.key | ', 'charset' => 'utf8'),
					'status' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'comment' => 'public status, 1: public, 2: public pending, 3: draft during 4: remand | 公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し |  | '),
				),
			),
			'create_table' => array(
				'circular_notices' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'block id | ブロックID | blocks.block_id | '),
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'circular notice key | 回覧板キー | Hash値 | ', 'charset' => 'utf8'),
					'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'circular notice\'s name | 回覧板名称 |  | ', 'charset' => 'utf8'),
					'posts_authority' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'posts authority. 0:general cannot post, 1:general can post | 投稿権限 0:一般は投稿できない, 1:一般は投稿できる  |  |'),
					'mail_notice_flag' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'flag for notice via mail when circular notice is opened. 0:do not send, 1:send | メール通知フラグ 0:通知しない, 1:通知する  |  |'),
					'mail_subject' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'mail subject | メール件名 |  | ', 'charset' => 'utf8'),
					'mail_body' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'mail body | メール本文 |  | ', 'charset' => 'utf8'),
					'is_auto_translated' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'translation type. 0:original , 1:auto translation | 翻訳タイプ  0:オリジナル、1:自動翻訳 |  | '),
					'translation_engine' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'translation engine | 翻訳エンジン |  | ', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | '),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 |  | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 |  | '),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
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
