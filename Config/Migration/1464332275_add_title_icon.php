<?php
/**
 * AddTitleIcon CakeMigration
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2016, NetCommons Project
 */

/**
 * AddTitleIcon CakeMigration
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Config\Migration
 */
class AddTitleIcon extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_title_icon';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'circular_notice_contents' => array(
					'title_icon' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'circular_notice_setting_key'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'circular_notice_contents' => array('title_icon'),
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
