<?php
/**
 * circular_notice_contentsのpublish_start及びpublish_endを変更するMigration
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Kitatsuji.Yuto <kitatsuji.yuto@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * circular_notice_contentsのpublish_start及びpublish_endを変更するMigration
 *
 * @package NetCommons\CircularNotices\Config\Migration
 */
class ChangePublish extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'change_publish';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'alter_field' => array(
				'circular_notice_contents' => array(
					'publish_start' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '回覧期間（開始日時）'),
					'publish_end' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'opend period (to)  | 回覧期間（終了日時） |  | '),
				),
			),
		),
		'down' => array(
			'alter_field' => array(
				'circular_notice_contents' => array(
					'publish_start' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => '回覧期間（開始日時）'),
					'publish_end' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'opend period (to)  | 回覧期間（終了日時） |  | '),
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
