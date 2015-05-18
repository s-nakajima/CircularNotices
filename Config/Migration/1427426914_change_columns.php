<?php
class ChangeColumns extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'change_columns';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'circular_notice_contents' => array(
					'choices_key' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'circular notice choices key | 回覧選択肢キー | circular_notices_choidces.key | ', 'charset' => 'utf8', 'after' => 'reply_type'),
					'target_users_key' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'circular notice target users key | 回覧先会員キー | circular_notices_choidces.key | ', 'charset' => 'utf8', 'after' => 'reply_deadline'),
				),
			),
			'alter_field' => array(
				'circular_notice_contents' => array(
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'cerculat notice content key | 回覧キー | Hash値 | ', 'charset' => 'utf8'),
					'status' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'comment' => 'public status, 1: public, 2: public pending, 3: draft during 4: remand | 公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し |  | '),
					'reply_type' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'reply type. 1:text field , 2:selection, 3:multiple selection | 回答方式  1:記述方式、2:択一方式、3:選択方式 |  | '),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'circular_notice_contents' => array('choices_key', 'target_users_key'),
			),
			'alter_field' => array(
				'circular_notice_contents' => array(
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'circular notice content key | 回覧キー | Hash値 | ', 'charset' => 'utf8'),
					'status' => array('type' => 'integer', 'null' => false, 'default' => 0, 'length' => 4, 'comment' => 'public status, 1: public, 2: public pending, 3: draft during 4: remand | 公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し |  | '),
					'reply_type' => array('type' => 'integer', 'null' => false, 'default' => '1', 'comment' => 'reply type. 1:text field , 2:selection, 3:multiple selection | 回答方式  1:記述方式、2:択一方式、3:選択方式 |  | '),
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
