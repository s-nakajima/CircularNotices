<?php
/**
 * CircularNotices CakeMigration
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * CircularNotices CakeMigration
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Config\Migration
 */
class DeleteUnnecessaryColumns extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'delete_unnecessary_columns';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'rename_field' => array(
				'circular_notice_contents' => array(
					'is_room_targeted_flag' => 'is_room_target',
					'reply_deadline_set_flag' => 'use_reply_deadline',
				),
				'circular_notice_target_users' => array(
					'read_flag' => 'is_read',
					'reply_flag' => 'is_reply',
				),
			),
			'drop_field' => array(
				'circular_notice_contents' => array('target_groups', 'is_auto_translated', 'translation_engine'),
				'circular_notice_settings' => array('mail_notice_flag', 'mail_subject', 'mail_body', 'is_auto_translated', 'translation_engine'),
				'circular_notice_target_users' => array('indexes' => array('circular_notice_content_id')),
			),
			'create_field' => array(
				'circular_notice_target_users' => array(
					'indexes' => array(
						'circular_notice_content_id' => array('column' => array('circular_notice_content_id', 'is_read'), 'unique' => 0),
					),
				),
			),
		),
		'down' => array(
			'rename_field' => array(
				'circular_notice_contents' => array(
					'is_room_target' => 'is_room_targeted_flag',
					'use_reply_deadline' => 'reply_deadline_set_flag',
				),
				'circular_notice_target_users' => array(
					'is_read' => 'read_flag',
					'is_reply' => 'reply_flag',
				),
			),
			'drop_field' => array(
				'circular_notice_target_users' => array('indexes' => array('circular_notice_content_id')),
			),
			'create_field' => array(
				'circular_notice_contents' => array(
					'target_groups' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'target groups  | 回覧対象グループ |  | ', 'charset' => 'utf8'),
					'is_auto_translated' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'translation type. 0:original , 1:auto translation | 翻訳タイプ  0:オリジナル、1:自動翻訳 |  | '),
					'translation_engine' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'translation engine | 翻訳エンジン |  | ', 'charset' => 'utf8'),
				),
				'circular_notice_settings' => array(
					'mail_notice_flag' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'flag for notice via mail when circular notice is opened. 0:do not send, 1:send | メール通知フラグ 0:通知しない, 1:通知する  |  |'),
					'mail_subject' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'mail subject | メール件名 |  | ', 'charset' => 'utf8'),
					'mail_body' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'mail body | メール本文 |  | ', 'charset' => 'utf8'),
					'is_auto_translated' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'translation type. 0:original , 1:auto translation | 翻訳タイプ  0:オリジナル、1:自動翻訳 |  | '),
					'translation_engine' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'translation engine | 翻訳エンジン |  | ', 'charset' => 'utf8'),
				),
				'circular_notice_target_users' => array(
					'indexes' => array(
						'circular_notice_content_id' => array(),
					),
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
