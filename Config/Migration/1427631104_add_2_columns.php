<?php
class Add2Columns extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_2_columns';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'circular_notice_target_users' => array(
					'read_datetime' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'read datetime | 閲覧日時 |  | ', 'after' => 'read_flag'),
					'reply_datetime' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'reply datetime | 回答日時 |  | ', 'after' => 'reply_flag'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'circular_notice_target_users' => array('read_datetime', 'reply_datetime'),
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
