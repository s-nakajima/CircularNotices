<?php
/**
 * CircularNoticeChoiceFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * CircularNoticeChoiceFixture
 */
class CircularNoticeChoiceFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'circular_notice_content_id' => '2',
			'value' => 'Lorem ipsum dolor sit amet',
			'weight' => '1',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:18',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:18'
		),
		array(
			'id' => '2',
			'circular_notice_content_id' => '2',
			'value' => 'aliquet feugiat',
			'weight' => '2',
			'created_user' => '1',
			'created' => '2015-03-09 09:25:18',
			'modified_user' => '1',
			'modified' => '2015-03-09 09:25:18'
		),
		array(
			'id' => '3',
			'circular_notice_content_id' => '3',
			'value' => 'Lorem ipsum dolor sit amet',
			'weight' => '1',
			'created_user' => '1',
			'created' => '2015-03-09 10:25:18',
			'modified_user' => '1',
			'modified' => '2015-03-09 10:25:18'
		),
		array(
			'id' => '4',
			'circular_notice_content_id' => '3',
			'value' => 'aliquet feugiat',
			'weight' => '2',
			'created_user' => '1',
			'created' => '2015-03-09 10:25:18',
			'modified_user' => '1',
			'modified' => '2015-03-09 10:25:18'
		),
		array(
			'id' => '5',
			'circular_notice_content_id' => '3',
			'value' => 'Convallis morbi fringilla gravida',
			'weight' => '3',
			'created_user' => '1',
			'created' => '2015-03-09 10:25:18',
			'modified_user' => '1',
			'modified' => '2015-03-09 10:25:18'
		),
		array(
			'id' => '6',
			'circular_notice_content_id' => '11',
			'value' => 'Convallis morbi fringilla gravida',
			'weight' => '3',
			'created_user' => '1',
			'created' => '2015-03-09 10:25:18',
			'modified_user' => '1',
			'modified' => '2015-03-09 10:25:18'
		),
		array(
			'id' => '7',
			'circular_notice_content_id' => '12',
			'value' => 'Convallis morbi fringilla gravida',
			'weight' => '3',
			'created_user' => '1',
			'created' => '2015-03-09 10:25:18',
			'modified_user' => '1',
			'modified' => '2015-03-09 10:25:18'
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
