<?php
/**
 * CircularNoticeContent Model
 *
 * @property User $User
 * @property CircularNoticeChoice $CircularNoticeChoice
 * @property CircularNoticeTargetUser $CircularNoticeTargetUser
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
 * CircularNoticeContent Model
 *
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @package NetCommons\CircularNotices\Model
 */
class CircularNoticeContent extends CircularNoticesAppModel {

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
			'subject' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('circular_notices', 'Subject')),
				),
			),
			'content' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('circular_notices', 'Content')),
				),
			),
			'reply_type' => array(
				'inList' => array(
					'rule' => array('inList', array(
						CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT,
						CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION,
						CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION,
					)),
					'message' => __d('net_commons', 'Invalid request.'),
				),
				'notEmptyChoices' => array(
					'rule' => array('validateNotEmptyChoices'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('circular_notices', 'Choice')),
				),
			),
			'is_room_targeted_flag' => array(
				'notEmpty' => array(
					'rule' => array('validateNotEmptyTargetUser'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('circular_notices', 'Circular Target')),
				),
			),
			'opened_period_from' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('circular_notices', 'Period')),
				),
				'datetime' => array(
					'rule' => array('datetime'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'opened_period_to' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('circular_notices', 'Period')),
				),
				'datetime' => array(
					'rule' => array('datetime'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
				'fromTo' => array(
					'rule' => array('validateDatetimeFromTo', array('from' => $this->data['CircularNoticeContent']['opened_period_from'])),
					'message' => __d('net_commons', 'Invalid request.'),
				)
			),
			'reply_deadline_set_flag' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('net_commons', 'Pleas input boolean.'),
				),
			),
		));

		if ($this->data['CircularNoticeContent']['reply_deadline_set_flag']) {
			$this->validate = Hash::merge($this->validate, array(
				'reply_deadline' => array(
					'notEmpty' => array(
						'rule' => array('notEmpty'),
						'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('circular_notices', 'Reply Deadline')),
					),
					'datetime' => array(
						'rule' => array('datetime'),
						'message' => __d('net_commons', 'Invalid request.'),
					),
					'between' => array(
						'rule' => array('validateDatetimeBetween', array(
							'from' => $this->data['CircularNoticeContent']['opened_period_from'],
							'to' => $this->data['CircularNoticeContent']['opened_period_to']
						)),
						'message' => __d('net_commons', 'Invalid request.'),
					)
				),
			));
		}

		return parent::beforeValidate($options);
	}

/**
 * Validate empty of target users.
 *
 * @param array $check check fields.
 * @return bool
 */
	public function validateNotEmptyTargetUser($check) {
		if (
			! $this->data['CircularNoticeContent']['is_room_targeted_flag'] &&
			! $this->data['CircularNoticeContent']['target_groups']
		) {
			return false;
		}
		return true;
	}

/**
 * Validate choices count.
 *
 * @param array $check check fields.
 * @return bool
 */
	public function validateNotEmptyChoices($check) {
		if (
			$this->data['CircularNoticeContent']['reply_type'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION ||
			$this->data['CircularNoticeContent']['reply_type'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION
		) {
			if (! isset($this->data['CircularNoticeChoices']) || count($this->data['CircularNoticeChoices']) == 0) {
				return false;
			}
		}
		return true;
	}

/**
 * Use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.OriginalKey',
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'created_user',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CircularNoticeChoice' => array(
			'className' => 'CircularNotices.CircularNoticeChoice',
			'foreignKey' => 'circular_notice_content_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => array('weight' => 'asc'),
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'CircularNoticeTargetUser' => array(
			'className' => 'CircularNotices.CircularNoticeTargetUser',
			'foreignKey' => 'circular_notice_content_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
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

		$now = date('Y-m-d H:i:s');

		$this->virtualFields['current_status'] =
			'CASE WHEN ' . $this->alias . '.status = \'' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_IN_DRAFT . '\' THEN ' .
				'\'' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_IN_DRAFT . '\' ' .
			'WHEN ' . $this->alias . '.status = \'' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_PUBLISHED . '\' THEN ' .
				'CASE WHEN ' . $this->alias . '.opened_period_from > \'' . $now . '\' THEN ' .
					'\'' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_RESERVED . '\' ' .
				'ELSE ' .
					'CASE WHEN ' . $this->alias . '.opened_period_to < \'' . $now . '\' THEN ' .
						'\'' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_CLOSED . '\' ' .
					'WHEN ' . $this->alias . '.reply_deadline_set_flag = 1 AND ' . $this->alias . '.reply_deadline < \'' . $now . '\' THEN ' .
						'\'' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_FIXED . '\' ' .
					'ELSE ' .
						'\'' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_OPEN . '\' ' .
					'END ' .
				'END ' .
			'END';
	}

/**
 * Get circular notice content
 *
 * @param int $id circular_notice_contents.id
 * @param int $userId user id
 * @return mixed
 */
	public function getCircularNoticeContent($id, $userId) {
		$this->__bindMyCircularNoticeTargetUser($userId, true);

		return $this->find('first', array(
			'recursive' => 1,
			'conditions' => array(
				'CircularNoticeContent.id' => $id,
			),
		));
	}

/**
 * Get circular notice content list for pagination
 *
 * @param string $blockKey circular_notice_contents.circular_notice_setting_key
 * @param int $userId user id
 * @param array $paginatorParams paginator params
 * @param int $defaultLimit default limit per page
 * @return array
 */
	public function getCircularNoticeContentsForPaginate($blockKey, $userId, $paginatorParams, $defaultLimit) {
		$this->__bindMyCircularNoticeTargetUser($userId, false);
		$this->virtualFields['user_status'] = $this->MyCircularNoticeTargetUser->virtualFields['user_status'];

		$conditions = array(
			'CircularNoticeContent.circular_notice_setting_key' => $blockKey,
			'OR' => array(
				'CircularNoticeContent.created_user' => $userId,
				array(
					'NOT' => array('CircularNoticeContent.user_status' => null),
					'OR' => array(
						array('CircularNoticeContent.current_status' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_OPEN),
						array('CircularNoticeContent.current_status' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_FIXED),
					)
				)
			),
		);

		if (isset($paginatorParams['status'])) {
			if (
				$paginatorParams['status'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_UNREAD ||
				$paginatorParams['status'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_READ_YET ||
				$paginatorParams['status'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_REPLIED
			) {
				$conditions['CircularNoticeContent.user_status'] = (int)$paginatorParams['status'];
			} else {
				$conditions['CircularNoticeContent.current_status'] = (int)$paginatorParams['status'];
			}
		}

		$order = array('CircularNoticeContent.modified' => 'desc');
		if (isset($paginatorParams['sort']) && isset($paginatorParams['direction'])) {
			$order = array($paginatorParams['sort'] => $paginatorParams['direction']);
		}

		$limit = $defaultLimit;
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
 * Save circular notice content
 *
 * @param array $data input data
 * @return bool
 * @throws InternalErrorException
 */
	public function saveCircularNoticeContent($data) {
		// 必要なモデル読み込み
		$this->loadModels([
			'CircularNoticeContent' => 'CircularNotices.CircularNoticeContent',
			'CircularNoticeChoice' => 'CircularNotices.CircularNoticeChoice',
			'CircularNoticeTargetUser' => 'CircularNotices.CircularNoticeTargetUser',
		]);

		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {

			// FIXME: 回覧先の取得（共通待ち）
			$users = $this->_getUsersStub();

			// 取得したUserでデータを差し替え
			$targetUsers = array();
			foreach ($users as $user) {
				$targetUsers[] = array(
					'CircularNoticeTargetUser' => array(
						'id' => null,
						'user_id' => $user['User']['id'],
					)
				);
			}
			$data['CircularNoticeTargetUsers'] = $targetUsers;

			// データセット＋検証
			$this->validateCircularNoticeContent($data);
			if (! $this->CircularNoticeChoice->validateCircularChoices($data)) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->CircularNoticeChoice->validationErrors);
			}
			if (! $this->CircularNoticeTargetUser->validateCircularNoticeTargetUsers($data)) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->CircularNoticeTargetUser->validationErrors);
			}
			if ($this->validationErrors) {
				return false;
			}

			// CircularNoticeContentを保存
			if (! $content = $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			// 保存されたCircularNoticeContentでデータを差し替え
			$data['CircularNoticeContent'] = $content['CircularNoticeContent'];

			// CircularNoticeChoicesを保存
			if (! $this->CircularNoticeChoice->replaceCircularNoticeChoices($data)) {
				return false;
			}

			// CircularNoticeTargetUsersを保存
			if (! $this->CircularNoticeTargetUser->replaceCircularNoticeTargetUsers($data)) {
				return false;
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
 * Validate this model
 *
 * @param array $data input data
 * @return bool
 */
	public function validateCircularNoticeContent($data) {
		$this->set($data);
		$this->validates();
		return $this->validationErrors ? false : true;
	}

/**
 * Delete circular notice content
 *
 * @param string $key circular_notice_contents.key
 * @return bool
 * @throws InternalErrorException
 */
	public function deleteCircularNoticeContent($key) {
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {

			// 削除対象となるIDを取得
			$targetIds = $this->find('list', array(
				'fields' => array('CircularNoticeContent.id', 'CircularNoticeContent.id'),
				'recursive' => -1,
				'conditions' => array(
					'CircularNoticeContent.key' => $key,
				)
			));

			// 関連するデータを一式削除
			if (count($targetIds) > 0) {
				foreach ($targetIds as $targetId) {
					if (! $this->CircularNoticeTargetUser->deleteAll(array('CircularNoticeTargetUser.circular_notice_content_id' => $targetId), false)) {
						throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
					}
					if (! $this->CircularNoticeChoice->deleteAll(array('CircularNoticeChoice.circular_notice_content_id' => $targetId), false)) {
						throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
					}
					if (! $this->delete($targetId, false)) {
						throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
					}
				}
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
 * Bind login user's circular notice target user.
 *
 * @param int $userId user id
 * @param bool $reset is reset bind
 * @return void
 */
	private function __bindMyCircularNoticeTargetUser($userId, $reset) {
		$this->bindModel(
			array('hasOne' => array(
				'MyCircularNoticeTargetUser' => array(
					'className' => 'CircularNotices.CircularNoticeTargetUser',
					'foreignKey' => 'circular_notice_content_id',
					'dependent' => false,
					'conditions' => array('MyCircularNoticeTargetUser.user_id' => $userId),
				),
			)), $reset
		);
	}
}
