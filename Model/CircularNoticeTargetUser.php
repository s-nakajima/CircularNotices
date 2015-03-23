<?php
/**
 * CircularNoticeTargetUser Model
 *
 * @property User $User
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CircularNoticesAppModel', 'CircularNotices.Model');

/**
 * CircularNoticeTargetUser Model
 */
class CircularNoticeTargetUser extends CircularNoticesAppModel {

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
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
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
		'read_flag' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'reply_flag' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * getCircularNoticeTargetUserCount method
 *
 * @param int $circularNoticeContentId circular_notice_content.id
 * @return array
 */
	public function getCircularNoticeTargetUserCount($circularNoticeContentId)
	{
		// 条件を設定
		$conditions = array(
			'CircularNoticeTargetUser.circular_notice_content_id' => $circularNoticeContentId,
		);

		// 回覧先件数を取得
		$circularNoticeTargetCount = $this->find('count', array(
			'conditions' => $conditions,
		));

		// 閲覧済件数を取得するため条件を追加
		$conditions += array(
			'CircularNoticeTargetUser.read_flag' => true,
		);

		// 閲覧済件数を取得
		$circularNoticeReadCount = $this->find('count', array(
			'conditions' => $conditions,
		));

		// 回答済件数を取得するため条件を追加
		$conditions += array(
			'CircularNoticeTargetUser.reply_flag' => true,
		);

		// 回答済件数を取得
		$circularNoticeReplyCount = $this->find('count', array(
			'conditions' => $conditions,
		));

		// 配列に詰めて返す
		return compact('circularNoticeTargetCount', 'circularNoticeReadCount', 'circularNoticeReplyCount');
	}

/**
 * getCircularNoticeTargetUserCount method
 *
 * @param int $circularNoticeContentId circular_notice_content.id
 * @param int $userId users.id
 * @return boolean
 */
//	public function isTarget($circularNoticeContentId, $userId)
//	{
//		// 条件を設定
//		$conditions = array(
//			'CircularNoticeTargetUser.circular_notice_content_id' => $circularNoticeContentId,
//			'CircularNoticeTargetUser.user_id' => $userId,
//		);
//
//		// 件数を取得
//		$count = $circularNoticeReplyCount = $this->find('count', array(
//			'conditions' => $conditions,
//		));
//
//		// 回覧先に含まれていない場合
//		if($count == 0) {
//			return false;
//		}
//		// 回覧先に含まれている場合
//		else {
//			return true;
//		}
//	}

}
