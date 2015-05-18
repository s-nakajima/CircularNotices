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
				'circular_notice_choices' => array(
					'weight' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'circular notice\'s choice value\'s weight | 選択肢表示順 |  | ', 'after' => 'modified'),
				),
			),
			'alter_field' => array(
				'circular_notice_choices' => array(
					'value' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'circular notice\'s choice value | 選択肢 |  | ', 'charset' => 'utf8'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'circular_notice_choices' => array('weight'),
			),
			'alter_field' => array(
				'circular_notice_choices' => array(
					'value' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'circular notice\'s choice value | 選択候補値 |  | ', 'charset' => 'utf8'),
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
