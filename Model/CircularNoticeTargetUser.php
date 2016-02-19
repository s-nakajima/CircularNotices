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
App::uses('CircularNoticeComponent', 'CircularNotices.Controller/Component');

/**
 * CircularNoticeTargetUser Model
 *
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @package NetCommons\CircularNotices\Model
 */
class CircularNoticeTargetUser extends CircularNoticesAppModel {

/**
 * Default display number
 *
 * @var int
 */
	const DEFAULT_DISPLAY_NUMBER = 10;

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * Called during validation operations, before validation. Please note that custom
 * validation rules can be defined in $validate.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforevalidate
 * @see Model::save()
 */
	public function beforeValidate($options = array()) {
		$this->validate = Hash::merge($this->validate, array(
//			'reply_text_value' => array(
//				'notEmpty' => array(
//					'rule' => array('validateNotEmptyReplyValue'),
//					'last' => false,
//					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('circular_notices', 'Answer Title')),
//				),
//			),
//			'user_id' => array(
//				'notBlank' => array(
//					'rule' => array('isUserSelected'),
//					'required' => true,
//					'message' => sprintf(__d('net_commons', 'ユーザを選択してください。')),
//				),
//			),
		));
		return parent::beforeValidate($options);
	}

/**
 * Validate empty of reply value.
 *
 * @param array $check check fields.
 * @return bool
 */
	public function validateNotEmptyReplyValue($check) {
		CakeLog::error(var_export($this->data['CircularNoticeTargetUser'], true));
		if (! $this->data['CircularNoticeTargetUser']['reply_text_value'] &&
			! $this->data['CircularNoticeTargetUser']['reply_selection_value']
		) {
			return false;
		}
		return true;
	}

	public function isUserSelected($check) {
		if (!isset($check['user_id']) || count($check['user_id']) === 0) {
			return false;
		}
		return true;
	}

	/**
 * Use behaviors
 *
 * @var array
 */
	public $actsAs = array(
//		'NetCommons.OriginalKey',
//		'CircularNotices.CircularNoticeTargetUser'
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CircularNoticeContent' => array(
			'className' => 'CircularNotices.CircularNoticeContent',
			'foreignKey' => 'circular_notice_content_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

/**
 * Constructor. Binds the model's database table to the object.
 *
 * @param bool|int|string|array $id Set this ID for this model on startup,
 * can also be an array of options, see above.
 * @param string $table Name of database table to use.
 * @param string $ds DataSource connection name.
 * @see Model::__construct()
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->virtualFields['user_status'] =
			'CASE WHEN ' . $this->alias . '.read_flag = 0 THEN ' .
				'\'' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_UNREAD . '\' ' .
			'WHEN ' . $this->alias . '.read_flag = 1 THEN ' .
				'CASE WHEN ' . $this->alias . '.reply_flag = 0 THEN ' .
					'\'' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_READ_YET . '\' ' .
				'WHEN ' . $this->alias . '.reply_flag = 1 THEN ' .
					'\'' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_REPLIED . '\' ' .
				'ELSE ' .
					'NULL ' .
				'END ' .
			'ELSE ' .
				'NULL ' .
			'END';
	}

/**
 * Get count of circular notice target user
 *
 * @param int $contentId circular_notice_target_users.circular_notice_content_id
 * @return array
 */
	public function getCircularNoticeTargetUserCount($contentId) {
		// 条件を設定
		$conditions = array(
			'CircularNoticeTargetUser.circular_notice_content_id' => $contentId,
		);

		// 回覧先件数を取得
		$targetCount = $this->find('count', array(
			'conditions' => $conditions,
		));

		// 閲覧済件数を取得するため条件を追加
		$conditions += array(
			'CircularNoticeTargetUser.read_flag' => true,
		);

		// 閲覧済件数を取得
		$readCount = $this->find('count', array(
			'conditions' => $conditions,
		));

		// 回答済件数を取得するため条件を追加
		$conditions += array(
			'CircularNoticeTargetUser.reply_flag' => true,
		);

		// 回答済件数を取得
		$replyCount = $this->find('count', array(
			'conditions' => $conditions,
		));

		// 配列に詰めて返す
		return compact('targetCount', 'readCount', 'replyCount');
	}

/**
 * Get circular notice target user of user
 *
 * @param int $contentId circular_notice_target_users.circular_notice_content_id
 * @param int $userId user id
 * @return mixed
 */
	public function getMyCircularNoticeTargetUser($contentId, $userId) {
		$conditions = array(
			'CircularNoticeTargetUser.circular_notice_content_id' => $contentId,
			'CircularNoticeTargetUser.user_id' => $userId,
		);

		return $this->find('first', array(
			'conditions' => $conditions
		));
	}

/**
 * Get circular notice target users
 *
 * @param int $contentId circular_notice_target_users.circular_notice_content_id
 * @return array
 */
	public function getCircularNoticeTargetUsers($contentId) {
		$conditions = array(
			'CircularNoticeTargetUser.circular_notice_content_id' => $contentId,
		);

		return $this->find('all', array(
			'conditions' => $conditions,
		));
	}

/**
 * Get circular notice target user list for pagination
 *
 * @param int $contentId circular_notice_target_users.circular_notice_content_id
 * @param array $paginatorParams paginator params
 * @param int $userId user id
 * @return array
 */
	public function getCircularNoticeTargetUsersForPaginator($contentId, $paginatorParams, $userId) {
		$this->virtualFields['first_order'] =
			'CASE WHEN CircularNoticeTargetUser.user_id = ' . $userId . ' THEN 1 ELSE 2 END';

		$conditions = array(
			'CircularNoticeTargetUser.circular_notice_content_id' => $contentId,
		);

		// 表示順
		$order = array('User.username' => 'asc');
		if (isset($paginatorParams['sort']) && isset($paginatorParams['direction'])) {
			$order = array($paginatorParams['sort'] => $paginatorParams['direction']);
		}

		// 表示件数
		$limit = self::DEFAULT_DISPLAY_NUMBER;
		if (isset($paginatorParams['limit'])) {
			$limit = (int)$paginatorParams['limit'];
		}

		return array(
			'recursive' => 0,
			'conditions' => $conditions,
			'order' => $order,
			'limit' => $limit,
		);
	}

/**
 * Hook for Paginator's paginate
 *
 * @param array $conditions conditions
 * @param array $fields fields
 * @param array $order order
 * @param int $limit limit
 * @param int $page page
 * @param int $recursive recursive
 * @param array $extra extra
 * @return mixed
 */
	public function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) {
		// ログイン者を先頭に持ってくるためにorderをカスタム
		$customOrder = array(array('CircularNoticeTargetUser.first_order' => 'asc'));
		if (! empty($order)) {
			$customOrder[] = $order;
		}
		$order = $customOrder;

		return $this->find('all', compact('conditions', 'fields', 'order', 'limit', 'page', 'recursive'));
	}

/**
 * Save for read
 *
 * @param int $contentId circular_notice_contents.id
 * @param int $userId user id
 * @return bool
 * @throws InternalErrorException
 */
	public function saveRead($contentId, $userId) {
		$target = $this->find('first', array(
			'conditions' => array(
				'CircularNoticeTargetUser.circular_notice_content_id' => $contentId,
				'CircularNoticeTargetUser.user_id' => $userId,
			)
		));

		if ($target['CircularNoticeTargetUser']['user_status'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_UNREAD) {
			if ($target['CircularNoticeContent']['current_status'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_OPEN ||
				$target['CircularNoticeContent']['current_status'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_FIXED
			) {
				$data = array(
					'CircularNoticeTargetUser' => array(
						'id' => $target['CircularNoticeTargetUser']['id'],
						'user_id' => $target['CircularNoticeTargetUser']['user_id'],
						'read_flag' => true,
						'read_datetime' => date('Y-m-d H:i:s'),
					)
				);

				if (! $this->saveCircularNoticeTargetUser($data)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
			}
		}

		return true;
	}

/**
 * Save circular notice target user
 *
 * @param array $data input data
 * @return bool
 * @throws InternalErrorException
 */
	public function saveCircularNoticeTargetUser($data) {
		// FIXME: これがあるとページネーションでこけてしまうため回避方法を探す
		//$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			// データセット＋検証
			$this->validate['reply_text_value'] = array(
				'notEmpty' => array(
					'rule' => array('validateNotEmptyReplyValue'),
					'last' => false,
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('circular_notices', 'Answer Title')),
				),
			);
			if (! $this->validateCircularNoticeTargetUser($data)) {
				return false;
			}

			// CircularNoticeTargetUserを保存
			if (! $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$dataSource->commit();

		} catch (Exception $ex) {
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}

		return true;
	}

/**
 * Delete-insert circular notice target users
 *
 * @param array $data input data
 * @return bool
 * @throws InternalErrorException
 */
	public function replaceCircularNoticeTargetUsers($data) {
		$contentId = $data['CircularNoticeContent']['id'];

		// すべてDelete
		if (! $this->deleteAll(array('CircularNoticeTargetUser.circular_notice_content_id' => $contentId), false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		// 1件ずつ保存
		if (isset($data['CircularNoticeTargetUsers']) && count($data['CircularNoticeTargetUsers']) > 0) {
			foreach ($data['CircularNoticeTargetUsers'] as $targetUser) {
	
				$targetUser['CircularNoticeTargetUser']['circular_notice_content_id'] = $contentId;
	
				if (! $this->validateCircularNoticeTargetUser($targetUser)) {
					return false;
				}
	
				if (! $this->save(null, false)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
			}
		}

		return true;
	}

/**
 * Validate this model
 *
 * @param array $data input data
 * @return bool
 */
	public function validateCircularNoticeTargetUser($data) {
		$this->set($data);
		$this->validates();
		return $this->validationErrors ? false : true;
	}

/**
 * Validate this models
 *
 * @param array $data input data
 * @return bool
 */
	public function validateCircularNoticeTargetUsers($data) {
		if (isset($data['CircularNoticeTargetUsers'])) {
			foreach ($data['CircularNoticeTargetUsers'] as $value) {
				if (!$this->validateCircularNoticeTargetUser($value)) {
					return false;
				}
			}
		}
		return true;
	}

/**
 * Get display numbers for limit options
 *
 * @return array
 */
	public static function getDisplayNumberOptions() {
		return array(
			10 => __d('circular_notices', '%d items', 10),
			20 => __d('circular_notices', '%d items', 20),
			30 => __d('circular_notices', '%d items', 30),
			40 => __d('circular_notices', '%d items', 40),
			50 => __d('circular_notices', '%d items', 50),
		);
	}
}
