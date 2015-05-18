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
 * @param int $circularNoticeContentId circular_notice_contents.id
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
 * getCircularNoticeTargetUser method
 *
 * @param int $circularNoticeContentId circular_notice_contents.id
 * @param int $userId users.id
 * @return array
 */
	public function getCircularNoticeTargetUser($circularNoticeContentId, $userId)
	{
		// 取得条件を設定
		$conditions = array(
			'CircularNoticeTargetUser.circular_notice_content_id' => $circularNoticeContentId,
			'NOT' => array(
				'CircularNoticeTargetUser.user_id' => $userId,
			),
		);

		// DBから取得した値を返す
		return $this->find('all', array(
			'conditions' => $conditions,
			'recursive' => 1,
		));
	}


/**
 * saveCircularNoticeTargetUser method
 *
 * @param array $data
 * @return boolean
 */
	public function saveCircularNoticeTargetUser($data, $validate = true)
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
 * validateCircularTargetUser method
 *
 * @param array $data
 * @return bool True on success, false on error
 */
	private function validateCircularTargetUser($data) {
		$this->set($data);
		$this->validates();
//		return $this->validationErrors ? false : true;
		return true;
	}

/**
 * getUserReadReplyFlag method
 *
 * @param int $circularNoticeContentId circular_notice_contents.id
 * @param int $userId users.id
 * @return array
 */
	public function getUserReadReplyFlag($circularNoticeContentId, $userId)
	{
		// 取得項目を設定
		$fields = array(
			'CircularNoticeTargetUser.read_flag',
			'CircularNoticeTargetUser.reply_flag',
		);

		// 取得条件を設定（frameKey）
		$conditions = array(
			'CircularNoticeTargetUser.circular_notice_content_id' => $circularNoticeContentId,
			'CircularNoticeTargetUser.user_id' => $userId,
		);

		// DBから取得した値を返す
		return $this->find('first', array(
			'fields' => $fields,
			'conditions' => $conditions,
		));
	}

/**
 * getUserSelectionValue method
 *
 * @param int $circularNoticeContentId circular_notice_contents.id
 * @param string $selection circular_notice_choices.value
 * @return int
 */
	public function getUserSelectionValue($circularNoticeContentId, $selection)
	{
		// 条件を設定
		$conditions = array(
			'CircularNoticeTargetUser.circular_notice_content_id' => $circularNoticeContentId,
			'CircularNoticeTargetUser.reply_selection_value' => $selection,
		);

		// 回覧先件数を取得
		return $this->find('count', array(
			'conditions' => $conditions,
		));
	}


/**
 * getMyAnswer method
 *
 * @param int $circularNoticeContentId circular_notice_contents.id
 * @param int $userId users.id
 * @return array
 */
	public function getMyAnswer($circularNoticeContentId, $userId)
	{
		// 取得項目を設定
		$fields = array(
			'CircularNoticeTargetUser.reply_text_value',
			'CircularNoticeTargetUser.reply_selection_value',
		);

		// 取得条件を設定（frameKey）
		$conditions = array(
			'CircularNoticeTargetUser.circular_notice_content_id' => $circularNoticeContentId,
			'CircularNoticeTargetUser.user_id' => $userId,
		);

		// DBから取得した値を返す
		return $this->find('first', array(
			'fields' => $fields,
			'conditions' => $conditions,
		));
	}

/**
 * setReadYet method
 *
 * @param int $circularNoticeContentId circular_notice_contents.id
 * @param int $userId users.id
 * @return array
 */
	public function setReadYet($circularNoticeContentId, $userId)
	{
		// 回答を再取得
		$circularNoticetargetuser = $this->find('first', array(
			'conditions' => array(
				'CircularNoticeTargetUser.circular_notice_content_id' => $circularNoticeContentId,
				'CircularNoticeTargetUser.user_id' => $userId,
				'CircularNoticeTargetUser.read_flag' => false,
			),
			'recursive' => -1,
		));

		if (! $circularNoticetargetuser) {
			return;
		}

		// 更新値を設定
		$circularNoticetargetuser['CircularNoticeTargetUser']['read_flag'] = true;
		$circularNoticetargetuser['CircularNoticeTargetUser']['read_datetime'] = date('Y-m-d H:i:s');
		$circularNoticetargetuser['CircularNoticeTargetUser']['modified_user'] = $userId;
		$circularNoticetargetuser['CircularNoticeTargetUser']['modified'] = date('Y-m-d H:i:s');

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			$this->save($circularNoticetargetuser);
			$dataSource->commit();
		} catch (Exception $ex) {
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}
	}


/**
 * saveReplyValue method
 *
 * @param array $replyData
 * @param int $userId users.id
 * @return array
 */
	public function saveReplyValue($replyData, $userId)
	{
		// 回答を再取得
		$circularNoticetargetuser = $this->find('first', array(
			'conditions' => array(
				'CircularNoticeTargetUser.circular_notice_content_id' => $replyData['circular_notice_content_id'],
				'CircularNoticeTargetUser.user_id' => $userId,
			),
			'recursive' => -1,
		));

		// 更新値を設定
		// 「記述式」の場合
		if (! $replyData['reply_selection_value']) {
			// 更新値を設定
			$circularNoticetargetuser['CircularNoticeTargetUser']['reply_text_value'] = $replyData['reply_text_value'];
		} else {
			if (is_array($replyData['reply_selection_value'])) {
				$reply_selection_value = '';
					foreach ($replyData['reply_selection_value']as $ans) {
						$reply_selection_value .= $ans . ',';
					}
				$reply_selection_value = substr($reply_selection_value, 0, -1);
			} else {
				$reply_selection_value = $replyData['reply_selection_value'];
			}
			// 更新値を設定
			$circularNoticetargetuser['CircularNoticeTargetUser']['reply_selection_value'] = $reply_selection_value;
		}

		$circularNoticetargetuser['CircularNoticeTargetUser']['reply_flag'] = true;
		$circularNoticetargetuser['CircularNoticeTargetUser']['reply_datetime'] = date('Y-m-d H:i:s');
		$circularNoticetargetuser['CircularNoticeTargetUser']['modified_user'] = $userId;
		$circularNoticetargetuser['CircularNoticeTargetUser']['modified'] = date('Y-m-d H:i:s');

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			$this->save($circularNoticetargetuser);
			$dataSource->commit();
		} catch (Exception $ex) {
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}
	}

}
