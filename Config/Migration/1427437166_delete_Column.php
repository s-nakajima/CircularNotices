<?php
class DeleteColumns extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'delete_column';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'drop_field' => array(
				'circular_notice_contents' => array('choices_key', 'target_users_key'),
			),
		),
		'down' => array(
			'create_field' => array(
				'circular_notice_contents' => array(
					'choices_key' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'circular notice choices key | 回覧選択肢キー | circular_notices_choidces.key | ', 'charset' => 'utf8'),
					'target_users_key' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'circular notice target users key | 回覧先会員キー | circular_notices_choidces.key | ', 'charset' => 'utf8'),
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
