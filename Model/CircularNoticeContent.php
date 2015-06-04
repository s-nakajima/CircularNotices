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

// FIXME: バリデーションの実装
// FIXME: 相関チェック類の実装方法（日付FromToとかラジオと連動する値とか）

		$this->validate = Hash::merge($this->validate, array(
			'subject' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('circular_notices', 'Subject')),
					'allowEmpty' => false,
					'required' => true,
				),
			),
			'content' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('circular_notices', 'Content')),
					'allowEmpty' => false,
					'required' => true,
				),
			),
//			'reply_type',
//			'is_room_targeted_flag',
//			'target_groups',
			'opened_period_from' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('circular_notices', 'Period')),
					'allowEmpty' => false,
					'required' => true,
				),
				'datetime' => array(
					'rule' => array('datetime'),
					'message' => 'Please enter a valid date and time.',
				),
			),
			'opened_period_to' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('circular_notices', 'Period')),
					'allowEmpty' => false,
					'required' => true,
				),
				'datetime' => array(
					'rule' => array('datetime'),
					'message' => 'Please enter a valid date and time.',
				),
			),

//			'reply_deadline_set_flag',
//			'reply_deadline',
//			'status',
		));

		return parent::beforeValidate($options);
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
 * Get circular notice content
 *
 * @param int $id
 * @return mixed
 */
	public function getCircularNoticeContent($id) {
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
 * @param string $blockKey
 * @param array $circularNoticeFrameSetting
 * @param array $paginatorParams
 * @param int $userId
 * @return array
 */
	public function getCircularNoticeContentsForPaginate($blockKey, $circularNoticeFrameSetting, $paginatorParams, $userId)
	{
		$fields = array(
			'*',
			'CircularNoticeContentCurrentStatus.current_status',
			'CircularNoticeContentMyStatus.my_status',
		);

		$joins = array();

		// 回覧ステータス取得用のJOIN
		$dataSource = $this->getDataSource();

		// 現時点での回覧ステータスを取得するためのJOIN
		$subQuery = $dataSource->buildStatement(
			array(
				'fields' => array(
					'id',
					'(CASE ' .
					'WHEN status = \'' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_IN_DRAFT . '\' THEN ' .
						'\'' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_IN_DRAFT . '\' ' .
					'WHEN status = \'' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_PUBLISHED . '\' THEN ' .
						'CASE ' .
						'WHEN opened_period_from > NOW() THEN ' .
							'\'' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_RESERVED . '\' ' .
						'ELSE ' .
							'CASE ' .
							'WHEN opened_period_to < NOW() THEN ' .
								'\'' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_CLOSED . '\' ' .
							'WHEN reply_deadline_set_flag = 1 AND reply_deadline < NOW() THEN ' .
								'\'' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_FIXED . '\' ' .
							'ELSE ' .
								'\'' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_OPEN . '\' ' .
							'END ' .
						'END ' .
					'END) AS current_status',
				),
				'table' => 'circular_notice_contents',
				'alias' => 'CircularNoticeContentCurrentStatus',
			),
			$this
		);
		$joins[] = array(
			'type' => 'LEFT',
			'table' => '(' . $subQuery . ')',
			'alias' => 'CircularNoticeContentCurrentStatus',
			'conditions' => array(
				'CircularNoticeContent.id = CircularNoticeContentCurrentStatus.id',
			),
		);

		// ログイン者用の回覧ステータスを取得するためのJOIN
		$subQuery = $dataSource->buildStatement(
			array(
				'fields' => array(
					'user_id',
					'circular_notice_content_id',
					'(CASE ' .
					'WHEN read_flag = 0 THEN ' .
						'\'' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_UNREAD . '\' ' .
					'ELSE ' .
						'CASE ' .
						'WHEN reply_flag = 0 THEN ' .
							'\'' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_READ_YET . '\' ' .
						'ELSE' .
							'\'' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_REPLIED . '\' ' .
						'END ' .
					'END) AS my_status'
				),
				'table' => 'circular_notice_target_users',
				'alias' => 'CircularNoticeContentMyStatus',
			),
			$this->CircularNoticeTargetUser
		);
		$joins[] = array(
			'type' => 'LEFT',
			'table' => '(' . $subQuery . ')',
			'alias' => 'CircularNoticeContentMyStatus',
			'conditions' => array(
				'CircularNoticeContent.id = CircularNoticeContentMyStatus.circular_notice_content_id',
				'CircularNoticeContentMyStatus.user_id' => $userId,
			),
		);

// FIXME: 回覧者じゃない場合は回覧期限の条件が必要
		// 取得条件の設定
		$conditions = array(
			'CircularNoticeContent.circular_notice_setting_key' => $blockKey,
			'OR' => array(
				'CircularNoticeContent.created_user' => $userId,
				'CircularNoticeContentMyStatus.my_status IS NOT NULL',
			),
		);

		// ステータス
		if (isset($paginatorParams['status'])) {
			switch ($paginatorParams['status']) {
				case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_PUBLISHED:
				case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_IN_DRAFT:
				case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_RESERVED:
				case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_OPEN:
				case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_FIXED:
				case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_CLOSED:
					$conditions['CircularNoticeContentCurrentStatus.current_status'] = (int)$paginatorParams['status'];
					break;
				case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_UNREAD:
				case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_READ_YET:
				case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_REPLIED:
					$conditions['CircularNoticeContentMyStatus.my_status'] = (int)$paginatorParams['status'];
					break;
			}
		}

		// 表示順
		$order =  array('CircularNoticeContent.created' => 'desc');
		if (isset($paginatorParams['sort']) && isset($paginatorParams['direction'])) {
			$order = array($paginatorParams['sort'] => $paginatorParams['direction']);
		}

		// 表示件数
		$limit = $circularNoticeFrameSetting['displayNumber'];
		if (isset($paginatorParams['limit'])) {
			$limit = (int)$paginatorParams['limit'];
		}

		return array(
			'fields' => $fields,
			'recursive' => -1,
			'joins' => $joins,
			'conditions' => $conditions,
			'order' => $order,
			'limit' => $limit,
		);
	}

/**
 * Save circular notice content
 *
 * @param array $data
 * @return bool
 * @throws Exception
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

			// データセット＋検証
			if (! $this->__validateCircularNoticeContent($data)) {
				return false;
			}

			// CircularNoticeContentを保存
			if (! $circularNoticeContent = $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			// 保存されたCircularNoticeContentでデータを差し替え
			$data['CircularNoticeContent'] = $circularNoticeContent['CircularNoticeContent'];

			// CircularNoticeChoicesを保存
			if (! $this->CircularNoticeChoice->replaceCircularNoticeChoices($data)) {
				return false;
			}

			// FIXME: 回覧先の取得（共通待ち）
			$users = $this->getUsersStub();

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
 * @param array $data
 * @return bool
 */
	private function __validateCircularNoticeContent($data) {
		$this->set($data);
		$this->validates();
		return $this->validationErrors ? false : true;
	}

/**
 * Delete circular notice content
 *
 * @param string $key
 * @return bool
 * @throws Exception
 * @throws InternalErrorException
 */
	public function deleteCircularNoticeContent($key) {

		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {

			// 削除対象となるIDを取得
			$targetIds = $this->find('list', array(
				'fields' => array('CircularNoticeContent.id', 'CircularNoticeContent.key'),
				'recursive' => -1,
				'conditions' => array(
					'CircularNoticeContent.key' => $key,
				)
			));

			// 関連するデータを一式削除
			if (count($targetIds) > 0) {
				foreach ($targetIds as $targetId => $targetKey) {
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
}
