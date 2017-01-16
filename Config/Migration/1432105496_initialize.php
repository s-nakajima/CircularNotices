<?php
/**
 * CircularNotices CakeMigration
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * CircularNotices CakeMigration
 *
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @package NetCommons\CircularNotices\Config\Migration
 */
class Initialize extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'initialize';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'circular_notice_choices' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID'),
					'circular_notice_content_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => '回覧ID'),
					'value' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '選択肢', 'charset' => 'utf8'),
					'weight' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => '選択肢表示順'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => '作成者'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '作成日時'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => '更新者'),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '更新日時'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'fk_circular_notice_target_users_circular_notice_contents1_idx' => array('column' => 'circular_notice_content_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'circular_notice_contents' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID'),
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => '回覧キー', 'charset' => 'utf8'),
					'circular_notice_setting_key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => '回覧板キー', 'charset' => 'utf8'),
					'subject' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '件名', 'charset' => 'utf8'),
					'content' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '本文', 'charset' => 'utf8'),
					'reply_type' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1, 'comment' => '回答方式  1:記述式、2:択一式、3:複数選択'),
					'is_room_targeted_flag' => array('type' => 'boolean', 'null' => true, 'default' => null, 'comment' => 'ルーム対象回覧フラグ'),
					'target_groups' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '回覧対象グループ', 'charset' => 'utf8'),
					'opened_period_from' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => '回覧期間（開始日時）'),
					'opened_period_to' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'opend period (to)  | 回覧期間（終了日時） |  | '),
					'reply_deadline_set_flag' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => '回答期限設定フラグ  0:unset , 1:set'),
					'reply_deadline' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '回答期限'),
					'status' => array('type' => 'integer', 'null' => false, 'default' => '3', 'length' => 1, 'comment' => '公開状況  1:公開中、3:下書き中'),
					'is_auto_translated' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'translation type. 0:original , 1:auto translation | 翻訳タイプ  0:オリジナル、1:自動翻訳 |  | '),
					'translation_engine' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'translation engine | 翻訳エンジン |  | ', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => '作成者'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '作成日時'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => '更新者'),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '更新日時'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'circular_notice_contents_key1' => array('column' => 'key', 'unique' => 0),
						'fk_circular_notice_contentscircular_notices1' => array('column' => 'circular_notice_setting_key', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'circular_notice_frame_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID'),
					'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'フレームKey', 'charset' => 'utf8'),
					'display_number' => array('type' => 'integer', 'null' => false, 'default' => '10', 'comment' => '表示回覧数 1件、5件、10件、20件、50件、100件'),
					'created_user' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => '作成者'),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => '作成日時'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => '更新者'),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '更新日時'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'fk_circular_notice_frame_settings_frames1' => array('column' => 'frame_key', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'circular_notice_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID'),
					'block_key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'ブロックKey', 'charset' => 'utf8'),
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => '回覧板キー', 'charset' => 'utf8'),
					'posts_authority' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'posts authority. 0:general cannot post, 1:general can post | 投稿権限 0:一般は投稿できない, 1:一般は投稿できる  |  |'),
					'mail_notice_flag' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'メール通知フラグ 0:通知しない, 1:通知する'),
					'mail_subject' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'メール件名', 'charset' => 'utf8'),
					'mail_body' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'メール本文', 'charset' => 'utf8'),
					'is_auto_translated' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'translation type. 0:original , 1:auto translation | 翻訳タイプ  0:オリジナル、1:自動翻訳 |  | '),
					'translation_engine' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'translation engine | 翻訳エンジン |  | ', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => '作成者'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '作成日時'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => '更新者'),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '更新日時'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'circular_notices_key1' => array('column' => 'key', 'unique' => 0),
						'fk_circular_notices_blocks1' => array('column' => 'block_key', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'circular_notice_target_users' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID'),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => '回覧先'),
					'circular_notice_content_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => '回覧ID'),
					'read_flag' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => '閲覧フラグ  0:未読、1:既読'),
					'read_datetime' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '閲覧日時'),
					'reply_flag' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => '回答フラグ  0:未回答、1:回答'),
					'reply_datetime' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'reply datetime | 回答日時 |  | '),
					'reply_text_value' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '回覧回答（記述式）', 'charset' => 'utf8'),
					'reply_selection_value' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '回覧回答（択一、複数選択）', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => '作成者'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '作成日時'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => '更新者'),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '更新日時'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'fk_circular_notice_target_users_circular_notice_contents1_idx' => array('column' => 'circular_notice_content_id', 'unique' => 0),
						'fk_circular_notice_target_users_users1' => array('column' => 'user_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			),
			'alter_field' => array(
				'circular_notice_target_users' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID'),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'comment' => '回覧先'),
					'circular_notice_content_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index', 'comment' => '回覧ID'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => '作成者'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => '更新者'),
					'reply_selection_value' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '回覧回答（択一、複数選択）', 'charset' => 'utf8'),
				),
				'circular_notice_contents' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID'),
					'reply_type' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1, 'unsigned' => false, 'comment' => '回答方式  1:記述式、2:択一式、3:複数選択'),
					'status' => array('type' => 'integer', 'null' => false, 'default' => '3', 'length' => 4, 'unsigned' => false, 'comment' => '公開状況  1:公開中、3:下書き中'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => '作成者'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => '更新者'),
				),
				'circular_notice_choices' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID'),
					'circular_notice_content_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index', 'comment' => '回覧ID'),
					'weight' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => '選択肢表示順'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => '作成者'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => '更新者'),
				),
				'circular_notice_frame_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID'),
					'display_number' => array('type' => 'integer', 'null' => false, 'default' => '10', 'unsigned' => false, 'comment' => '表示回覧数 1件、5件、10件、20件、50件、100件'),
					'created_user' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'comment' => '作成者'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => '更新者'),
				),
				'circular_notice_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => '作成者'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => '更新者'),
				),
			),
			'drop_field' => array(
				'circular_notice_choices' => array('indexes' => array('fk_circular_notice_target_users_circular_notice_contents1_idx')),
				'circular_notice_contents' => array('indexes' => array('circular_notice_contents_key1', 'fk_circular_notice_contentscircular_notices1')),
				'circular_notice_frame_settings' => array('indexes' => array('fk_circular_notice_frame_settings_frames1')),
				'circular_notice_settings' => array('posts_authority', 'indexes' => array('circular_notices_key1', 'fk_circular_notices_blocks1')),
				'circular_notice_target_users' => array('indexes' => array('fk_circular_notice_target_users_circular_notice_contents1_idx', 'fk_circular_notice_target_users_users1')),
			),
			'create_field' => array(
				'circular_notice_contents' => array(
					'language_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'after' => 'circular_notice_setting_key'),
					'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'after' => 'language_id'),
					'is_latest' => array('type' => 'boolean', 'null' => true, 'default' => null, 'after' => 'is_active'),
					'public_type' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 4, 'unsigned' => false, 'after' => 'target_groups'),
					'title_icon' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'circular_notice_setting_key'),
					'indexes' => array(
						'key' => array('column' => 'key', 'unique' => 0),
						'circular_notice_setting_key' => array('column' => 'circular_notice_setting_key', 'unique' => 0),
					),
				),
				'circular_notice_choices' => array(
					'indexes' => array(
						'circular_notice_content_id' => array('column' => array('circular_notice_content_id', 'weight'), 'unique' => 0),
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
			'rename_field' => array(
				'circular_notice_contents' => array(
					'opened_period_from' => 'publish_start',
					'opened_period_to' => 'publish_end',
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'circular_notice_choices', 'circular_notice_contents', 'circular_notice_frame_settings', 'circular_notice_settings', 'circular_notice_target_users'
			),
			'alter_field' => array(
				'circular_notice_target_users' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID'),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => '回覧先'),
					'circular_notice_content_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => '回覧ID'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => '作成者'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => '更新者'),
					'reply_selection_value' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '回覧回答（択一、複数選択）', 'charset' => 'utf8'),
				),
				'circular_notice_contents' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID'),
					'reply_type' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1, 'comment' => '回答方式  1:記述式、2:択一式、3:複数選択'),
					'status' => array('type' => 'integer', 'null' => false, 'default' => '3', 'length' => 1, 'comment' => '公開状況  1:公開中、3:下書き中'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => '作成者'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => '更新者'),
				),
				'circular_notice_choices' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID'),
					'circular_notice_content_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => '回覧ID'),
					'weight' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => '選択肢表示順'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => '作成者'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => '更新者'),
				),
				'circular_notice_frame_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID'),
					'display_number' => array('type' => 'integer', 'null' => false, 'default' => '10', 'comment' => '表示回覧数 1件、5件、10件、20件、50件、100件'),
					'created_user' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => '作成者'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => '更新者'),
				),
				'circular_notice_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => '作成者'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => '更新者'),
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
					'posts_authority' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'posts authority. 0:general cannot post, 1:general can post | 投稿権限 0:一般は投稿できない, 1:一般は投稿できる  |  |'),
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
				'circular_notice_contents' => array('language_id', 'is_active', 'is_latest', 'public_type', 'title_icon', 'indexes' => array('key', 'circular_notice_setting_key')),
				'circular_notice_choices' => array('indexes' => array('circular_notice_content_id')),
				'circular_notice_frame_settings' => array('indexes' => array('frame_key')),
				'circular_notice_settings' => array('indexes' => array('block_key')),
				'circular_notice_target_users' => array('indexes' => array('circular_notice_content_id', 'circular_notice_content_id_2')),
			),
			'rename_field' => array(
				'circular_notice_contents' => array(
					'publish_start' => 'opened_period_from',
					'publish_end' => 'opened_period_to',
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
