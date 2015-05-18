<?php
class AddStatusColumnsToCircularNoticeContents extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_status_columns_to_circular_notice_contents';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'circular_notice_contents' => array(
					'status' => array('type' => 'integer', 'null' => false, 'default' => '3', 'length' => 1, 'comment' => 'status, 1: public, 3: draft during | 公開状況  1:公開中3:下書き中、 |  | ', 'after' => 'reply_deadline'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'circular_notice_contents' => array('status'),
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
