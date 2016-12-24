<?php
/**
 * CircularNoticeFrameSettingFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * CircularNoticeFrameSettingFixture
 */
class CircularNoticeFrameSettingFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'frame_key' => 'frame_1',
			'display_number' => '10',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:22',
			'modified_user' => 's',
			'modified' => '2015-03-09 09:25:22'
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
