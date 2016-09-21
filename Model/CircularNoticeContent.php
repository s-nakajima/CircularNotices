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
App::uses('MailQueueBehavior', 'Mails.Model/Behavior');
App::uses('WorkflowComponent', 'Workflow.Controller/Component');

/**
 * CircularNoticeContent Model
 *
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @package NetCommons\CircularNotices\Model
 */
class CircularNoticeContent extends CircularNoticesAppModel {

/**
 * Use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.OriginalKey',
		'CircularNotices.CircularNoticeTargetUser',
		'Workflow.Workflow',
		'Mails.MailQueue' => array(
			'embedTags' => array(
				'X-SUBJECT' => 'CircularNoticeContent.subject',
				'X-BODY' => 'CircularNoticeContent.content',
			),
		),
		'Topics.Topics' => array(
			'fields' => array(
				'title' => 'CircularNoticeContent.subject',
				'summary' => 'CircularNoticeContent.content',
				'answer_period_start' => 'CircularNoticeContent.publish_start',
				'answer_period_end' => 'CircularNoticeContent.reply_deadline',
				'path' => '/:plugin_key/:plugin_key/view/:block_id/:content_key',
			),
			'data' => array(
				'is_no_member_allow' => '0'
			),
			'is_workflow' => false
		),
		'Wysiwyg.Wysiwyg' => array(
			'fields' => array('content'),
		),
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
		$this->validate = Hash::merge($this->validate, $this->_getDefaultValidate());
		if ($this->data['CircularNoticeContent']['publish_start']) {
			$this->validate = Hash::merge($this->validate, array(
				'publish_start' => array(
					'notBlank' => array(
						'rule' => array('notBlank'),
						'message' => sprintf(__d('net_commons', 'Please input %s.'),
						__d('circular_notices', 'Period')),
					),
					'datetime' => array(
						'rule' => array('datetime'),
						'message' => __d('net_commons', 'Invalid request.'),
					),
				)
			));
		}
		if ($this->data['CircularNoticeContent']['publish_end']) {
			$this->validate = Hash::merge($this->validate, array(
				'publish_end' => array(
					'notBlank' => array(
						'rule' => array('notBlank'),
						'message' => sprintf(__d('net_commons', 'Please input %s.'),
								__d('circular_notices', 'Period')),
					),
					'datetime' => array(
						'rule' => array('datetime'),
						'message' => __d('net_commons', 'Invalid request.'),
					),
					'fromTo' => array(
						'rule' => array('validateDatetimeFromTo',
								array('from' => $this->data['CircularNoticeContent']['publish_start'])),
						'message' => __d('net_commons', 'Invalid request.'),
					)
				)
			));
		}
		if ($this->data['CircularNoticeContent']['use_reply_deadline']) {
			$this->validate = Hash::merge($this->validate, array(
				'use_reply_deadline' => array(
					'boolean' => array(
						'rule' => array('boolean'),
						'message' => __d('net_commons', 'Pleas input boolean.'),
					)
				)
			));
		}
		if ($this->data['CircularNoticeContent']['use_reply_deadline']) {
			$this->validate = Hash::merge($this->validate, array(
				'reply_deadline' => array(
					'notBlank' => array(
						'rule' => array('notBlank'),
						'message' => sprintf(__d('net_commons', 'Please input %s.'),
							__d('circular_notices', 'Reply Deadline')),
					),
					'datetime' => array(
						'rule' => array('datetime'),
						'message' => __d('net_commons', 'Invalid request.'),
					),
					'between' => array(
						'rule' => array('validateDatetimeBetween', array(
							'from' => $this->data['CircularNoticeContent']['publish_start'],
							'to' => $this->data['CircularNoticeContent']['publish_end']
						)),
						'message' => __d('circular_notices', 'Please input between circular period.'),
					)
				)
			));
		}
		return parent::beforeValidate($options);
	}

/**
 * 基本バリデートルール取得
 *
 * @return array
 */
	protected function _getDefaultValidate() {
		$validate = array(
			'subject' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'),
							__d('circular_notices', 'Subject')),
				),
			),
			'content' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'),
							__d('circular_notices', 'Content')),
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
					'message' => sprintf(__d('net_commons', 'Please input %s.'),
							__d('circular_notices', 'Choice')),
				),
			),
			'is_room_target' => array(
				'inList' => array(
					'rule' => array('inList', array(
						1,
						0,
					)),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'use_reply_deadline' => array(
				'inList' => array(
					'rule' => array('inList', array(
						1,
						0,
					)),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
		);

		return $validate;
	}

/**
 * Validate choices count.
 *
 * @param array $check check fields.
 * @return bool
 */
	public function validateNotEmptyChoices($check) {
		if ($this->data['CircularNoticeContent']['reply_type'] ==
			CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION ||
			$this->data['CircularNoticeContent']['reply_type'] ==
			CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION
		) {
			if (! isset($this->data['CircularNoticeChoices']) ||
				count($this->data['CircularNoticeChoices']) == 0) {
				return false;
			}
		}
		return true;
	}

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

		$this->virtualFields['content_status'] =
			'CASE WHEN ' . $this->alias . '.status = \'' .
				CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_IN_DRAFT . '\' THEN ' .
				'\'' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_IN_DRAFT . '\' ' .
			'WHEN ' . $this->alias . '.status = \'' .
					CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_PUBLISHED . '\' THEN ' .
				'CASE WHEN ' . $this->alias . '.publish_start > \'' . $now . '\' THEN ' .
					'\'' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_RESERVED . '\' ' .
				'ELSE ' .
					'CASE WHEN ' . $this->alias . '.publish_end < \'' . $now . '\' THEN ' .
						'\'' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_CLOSED . '\' ' .
					'WHEN ' . $this->alias . '.use_reply_deadline = 1 AND ' .
						$this->alias . '.reply_deadline < \'' . $now . '\' THEN ' .
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
 * @param string $key circular_notice_contents.key
 * @param int $userId user id
 * @return mixed
 */
	public function getCircularNoticeContent($key, $userId) {
		if (empty($userId)) {
			return false;
		}
		$this->__bindMyCircularNoticeTargetUser($userId, true);
		$conditions = array(
			'CircularNoticeContent.key' => $key,
		);

		return $this->find('first', array(
			'recursive' => 1,
			'conditions' => $this->getWorkflowConditions($conditions),
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
	public function getCircularNoticeContentsForPaginate($blockKey, $userId, $paginatorParams,
														$defaultLimit) {
		$this->__bindMyCircularNoticeTargetUser($userId, false);
		$this->virtualFields['reply_status'] =
			$this->MyCircularNoticeTargetUser->virtualFields['reply_status'];

		$conditions = $this->getWorkflowConditions();
		$conditions[] = array(
			'CircularNoticeContent.circular_notice_setting_key' => $blockKey,
			'OR' => array(
				'CircularNoticeContent.created_user' => $userId,
				Current::read('Permission.content_editable.role_key')
					=== Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
				array(
					'NOT' => array('CircularNoticeContent.reply_status' => null),
					'OR' => array(
						array('CircularNoticeContent.content_status' =>
							CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_OPEN),
						array('CircularNoticeContent.content_status' =>
							CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_FIXED),
					)
				)
			),
		);

		if (isset($paginatorParams['reply_status'])) {
			// 未回答の場合
			if ($paginatorParams['reply_status'] ==
					CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_NOT_REPLIED) {
				$conditions['CircularNoticeContent.reply_status'] = array(
					CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_UNREAD,
					CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_READ_YET
				);
			} else {
				$conditions['CircularNoticeContent.reply_status'] = (int)$paginatorParams['reply_status'];
			}
		}
		if (isset($paginatorParams['content_status'])) {
			$conditions['CircularNoticeContent.content_status'] = (int)$paginatorParams['content_status'];
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

		$this->begin();

		try {
			$users = array();
			if (isset($data['CircularNoticeTargetUser'])) {
				$users = $data['CircularNoticeTargetUser'];
			}
			$data = $this->__checkUseReplyDeadline($data);

			// ルームに所属する全ユーザが対象の場合、ルームの参加者を取得
			if ($data['CircularNoticeContent']['is_room_target']) {
				$this->loadModels([
					'RolesRoomsUser' => 'Rooms.RolesRoomsUser',
				]);
				$rolesRoomsUsers = $this->RolesRoomsUser->getRolesRoomsUsers(array(
					'Room.id' => Current::read('Room.id')
				));
				$targetUsers = Hash::extract($rolesRoomsUsers, '{n}.RolesRoomsUser.user_id');
				$users = $targetUsers;
				// 取得したUserでデータを差し替え
				$targetUsers = array();
				foreach ($users as $userId) {
					$targetUsers[] = array(
						'CircularNoticeTargetUser' => array(
							'id' => null,
							'user_id' => $userId,
						)
					);
				}
			} else {
				//新着データのユーザIDセット
				$this->setTopicUsers(Hash::extract($users, '{n}.user_id'));

				$targetUsers = Hash::map($users, '{n}.user_id', function ($value) {
					return array(
						'CircularNoticeTargetUser' => array(
							'id' => null,
							'user_id' => $value,
					));
				});
			}
			$data['CircularNoticeTargetUsers'] = $targetUsers;

			// データセット＋検証
			$this->validateCircularNoticeContent($data);
			if (! $this->CircularNoticeChoice->validateCircularChoices($data)) {
				$this->validationErrors =
					Hash::merge($this->validationErrors, $this->CircularNoticeChoice->validationErrors);
			}
			if ($this->validationErrors) {
				return false;
			}

			// メール処理
			$this->__sendCircularNoticeContentMail($data);

			// CircularNoticeContentを保存
			if (! $content = $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			// 保存されたCircularNoticeContentでデータを差し替え
			$data['CircularNoticeContent'] = $content['CircularNoticeContent'];

			// CircularNoticeChoices・CircularNoticeTargetUsersを保存
			if (! $this->__saveChoiceAndTargetUsers($data)) {
				return false;
			}

			$this->commit();

		} catch (Exception $ex) {
			$this->rollback();
			CakeLog::error($ex);
			throw $ex;
		}

		return $data;
	}

/**
 * Send Circular Notice Content Mail
 *
 * @param array $data array data
 * @return array $data array data
 */
	private function __sendCircularNoticeContentMail($data) {
		// メール処理
		$sendTimes = array($data['CircularNoticeContent']['publish_start']);
		$reminder = $this->setSendTimeReminder($sendTimes);
		$mailSendUserIdArr =
				Hash::extract($data, 'CircularNoticeTargetUsers.{n}.CircularNoticeTargetUser.user_id');
		$this->setSetting(MailQueueBehavior::MAIL_QUEUE_SETTING_USER_IDS, $mailSendUserIdArr);
		if ($reminder) {
			// リマインダーメールとの重複を防ぐためグループ配信のみにする
			$this->setSetting(MailQueueBehavior::MAIL_QUEUE_SETTING_IS_MAIL_SEND_POST, 0);
		}

		return $data;
	}

/**
 * Check Use Reply Deadline
 *
 * @param array $data input data
 * @return array $data
 */
	private function __checkUseReplyDeadline($data) {
		// 回答期限を設定していない場合初期化する
		if (! $data['CircularNoticeContent']['use_reply_deadline']) {
			$data['CircularNoticeContent']['reply_deadline'] = '';
		}

		return $data;
	}

/**
 * Save circular notice choices and target users
 *
 * @param array $data input data
 * @return bool
 */
	private function __saveChoiceAndTargetUsers($data) {
		// 必要なモデル読み込み
		$this->loadModels([
			'CircularNoticeChoice' => 'CircularNotices.CircularNoticeChoice',
			'CircularNoticeTargetUser' => 'CircularNotices.CircularNoticeTargetUser',
		]);
		// CircularNoticeChoicesとCircularNoticeTargetUsersを保存
		if (!$this->CircularNoticeChoice->replaceCircularNoticeChoices($data)
			|| !$this->CircularNoticeTargetUser->replaceCircularNoticeTargetUsers($data)) {
			return false;
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
		$this->begin();

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
				$this->contentKey = $key;
				if (! $this->CircularNoticeTargetUser->deleteAll(
					array('CircularNoticeTargetUser.circular_notice_content_id' => $targetIds), false)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
				if (! $this->CircularNoticeChoice->deleteAll(
					array('CircularNoticeChoice.circular_notice_content_id' => $targetIds), false)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
				if (! $this->deleteAll(array($this->alias . '.key' => $key), false, true)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
			}

			$this->commit();

		} catch (Exception $ex) {
			$this->rollback();
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
