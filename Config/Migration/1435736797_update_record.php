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
class UpdateRecord extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'update_record';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
		),
		'down' => array(
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
		if ($direction === 'down') {
			return true;
		}

		$model = $this->generateModel('plugins');
		$record = $model->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'plugins.key' => 'circular_notices',
			),
		));
		$record['plugins']['default_setting_action'] = 'circular_notice_block_role_permissions/edit';
		if (! $model->save($record, false)) {
			return false;
		}
		return true;
	}
}
