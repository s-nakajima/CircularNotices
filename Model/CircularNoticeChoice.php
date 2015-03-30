<?php
/**
 * CircularNoticeChoice Model
 *
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CircularNoticesAppModel', 'CircularNotices.Model');

/**
 * CircularNoticeChoice Model
 */
class CircularNoticeChoice extends CircularNoticesAppModel {

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'master';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'key' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'content_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'value' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

/**
 * getCircularNoticeChoice method
 *
 * @param int $circularNoticeContentId circular_notice_contents.id
 * @return array
 */
	public function getCircularNoticeChoice($circularNoticeContentId)
	{
		// 取得条件を設定
		$conditions = array(
			'CircularNoticeChoice.circular_notice_content_id' => $circularNoticeContentId,
		);

		// DBから取得した値を返す
		return $this->find('all', array(
			'conditions' => $conditions,
			'recursive' => -1,
			'order' => 'CircularNoticeChoice.weight asc',
		));
	}

/**
 * saveCircularNoticeChoice method
 *
 * @param array $data
 * @return boolean
 */
	public function saveCircularNoticeChoice($data, $validate = true)
	{
		// if (!$this->validateCircularTargetUser($data)) {
		// 	return false;
		// }

		$circularNoticeTargetUser = $this->saveAll($data['CircularNoticeTargetUser']);
		if (! $circularNoticeTargetUser) {
			// @codeCoverageIgnoreStart
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			// @codeCoverageIgnoreEnd
		}
		return $circularNoticeTargetUser;
	}

/**
 * validateCircularChoice method
 *
 * @param array $data
 * @return bool True on success, false on error
 */
	private function validateCircularChoice($data) {
		$this->set($data);
		$this->validates();
//		return $this->validationErrors ? false : true;
		return true;
	}

}
