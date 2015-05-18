<?php
class Add2Colomuns extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_2_Columns';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'circular_notice_contents' => array(
					'is_room_targeted_flag' => array('type' => 'boolean', 'null' => true, 'default' => null, 'comment' => 'is room targeted flag. 0:no , 1:yes  | ルーム対象回覧フラグ |  | ', 'after' => 'choices_key'),
					'target_groups' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'target groups  | 回覧対象グループ |  | ', 'charset' => 'utf8', 'after' => 'is_room_targeted_flag'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'circular_notice_contents' => array('is_room_targeted_flag', 'target_groups'),
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
