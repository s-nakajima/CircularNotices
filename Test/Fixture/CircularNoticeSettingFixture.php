<?php
/**
 * CircularNoticeSettingFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * CircularNoticeSettingFixture
 */
class CircularNoticeSettingFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'block_key' => 'block_1',
			'key' => 'circular_notice_setting_1',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:26',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:27'
		),
		array(
			'id' => '2',
			'block_key' => 'block_1',
			'key' => 'circular_notice_setting_2',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:26',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:27'
		),
		array(
			'id' => '3',
			'block_key' => 'block_1',
			'key' => 'circular_notice_3',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:26',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:27'
		),
		array(
			'id' => '4',
			'block_key' => 'block_1',
			'key' => 'circular_notice_4',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:26',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:27'
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('CircularNotices') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new CircularNoticesSchema())->tables[Inflector::tableize($this->name)];
		parent::init();
	}

}
