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
 * getReplyType method
 *
 * @return array
 */
	public function getReplyType()
	{
		$selectOption = array(
			// 記述方式
			array(
				'num' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT,
				'label' => __d('circular_notices', 'Reply Type Text')
			),
			// 新着順（降順）
			array(
				'num' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION,
				'label' => __d('circular_notices', 'Reply Type Selection')
			),
			// 回答期限順（降順）
			array(
				'num' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION,
				'label' => __d('circular_notices', 'Reply Type Multiple Selection')
			),
		);

		return selectOption;
	}

}
