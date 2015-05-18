<?php
/**
 * CircularNoticeContent Model
 *
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CircularNoticesAppModel', 'CircularNotices.Model');
App::uses('CircularNoticeComponent', 'CircularNotices.Controller/Component');
//App::uses('NetCommonsWorkflowComponent', 'NetCommons.Controller/Component');

/**
 * CircularNoticeContent Model
 */
class CircularNoticeContent extends CircularNoticesAppModel {

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
		'circular_notice_key' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'status' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'subject' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'content' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'reply_type' => array(
			'boolean' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'opened_period_from' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'opened_period_to' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'reply_deadline_set_fag' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_auto_translated' => array(
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
			'order' => '',
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
 * getCircularNoticeFrameSetting method
 *
 * @param string $circularNoticeKey circular_notice.key
 * @param int $userId users.id
 * @param array $permission
 * @param int $status
 * @param int $displayOrder
 * @return array
 */
	public function getCircularNoticeContentList($circularNoticeKey, $userId, $permission, $status = CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_ALL, $displayOrder = CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_DISPLAY_ORDER_NEW_ARRIVAL)
	{
		// 回覧一覧で使用する項目を取得
		$circularNoticeContents = $this->__getCircularNoticeContentList($circularNoticeKey, $userId, $permission, $status, $displayOrder);

		foreach($circularNoticeContents as &$circularNoticeContent) {
			// ステータスを設定
			$this->__setContentStatus($circularNoticeContent, $userId);

			// 回覧に関する諸件数を取得
			$count = $this->CircularNoticeTargetUser->getCircularNoticeTargetUserCount((int)$circularNoticeContent['CircularNoticeContent']['id']);

			// 回覧データに追加
			$circularNoticeContent['circularNoticeTargetCount'] = $count['circularNoticeTargetCount'];
			$circularNoticeContent['circularNoticeReadCount'] = $count['circularNoticeReadCount'];
			$circularNoticeContent['circularNoticeReplyCount'] = $count['circularNoticeReplyCount'];
		}

		return $circularNoticeContents;
	}

/**
 * __setContentStatus method
 *
 * @param array $circularNoticeContent
 * @param int $userId users.id
 * @return void
 */
	private function __setContentStatus(&$circularNoticeContent, $userId) {
		switch ($circularNoticeContent['CircularNoticeContent']['status']) {
			// 「一時保存」の場合
			case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_IN_DRAFT:
			// 「承認待ち」の場合
			case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_APPROVED:
			// 「差し戻し」の場合
			case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_DISAPPROVED:
				$circularNoticeContent['circularNoticeContentStatus'] = $circularNoticeContent['CircularNoticeContent']['status'];
				break;
			// 「公開中」の場合
			case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_PUBLISHED:
				// 回覧作成者の場合
				if ($this->__isCreater((int)$circularNoticeContent['CircularNoticeContent']['id'], $userId)) {
					// 回覧期間（開始日時）前の場合は「公開前」
					if($circularNoticeContent['CircularNoticeContent']['opened_period_from'] > date("Y-m-d H:i:s", time())) {
						$circularNoticeContent['circularNoticeContentStatus'] = CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_RESERVED;
						break;
					}

					// 回答期限が設定されている場合
					if ($circularNoticeContent['CircularNoticeContent']['reply_deadline_set_flag']) {
						// 回覧期限を超過している場合は「回覧終了」
						if($circularNoticeContent['CircularNoticeContent']['opened_period_to'] < date("Y-m-d H:i:s", time())) {
							$circularNoticeContent['circularNoticeContentStatus'] = CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_CLOSED;
						} else {
							// 回答期限を超過している場合は「回答受付終了」
							if($circularNoticeContent['CircularNoticeContent']['reply_deadline'] < date("Y-m-d H:i:s", time())) {
								$circularNoticeContent['circularNoticeContentStatus'] = CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_FIXED;
							}
							// その他の場合は「回覧中」
							else {
								$circularNoticeContent['circularNoticeContentStatus'] = CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_OPEN;
							}
						}
					}
					// 回答期限が設定されていない場合
					else {
						// 回覧期限を超過している場合は「回覧終了」
						if($circularNoticeContent['CircularNoticeContent']['opened_period_to'] < date("Y-m-d H:i:s", time())) {
							$circularNoticeContent['circularNoticeContentStatus'] = CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_CLOSED;
						}
						// その他の場合は「回覧中」
						else {
							$circularNoticeContent['circularNoticeContentStatus'] = CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_OPEN;
						}
					}
				}
				// 回覧作成者ではない場合
				else {
					// 回答期限が設定されている場合
					if ($circularNoticeContent['CircularNoticeContent']['reply_deadline_set_flag']) {
						// 回覧期限を超過している場合は「回覧終了」
						if($circularNoticeContent['CircularNoticeContent']['opened_period_to'] < date("Y-m-d H:i:s", time())) {
							$circularNoticeContent['circularNoticeContentStatus'] = CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_CLOSED;
							break;
						} else {
							// 回答期限を超過している場合は「回答受付終了」
							if($circularNoticeContent['CircularNoticeContent']['reply_deadline'] < date("Y-m-d H:i:s", time())) {
								$circularNoticeContent['circularNoticeContentStatus'] = CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_FIXED;
								break;
							}
						}
					}
					// 回答期限が設定されていない場合
					else {
						// 回覧期限を超過している場合は「回覧終了」
						if($circularNoticeContent['CircularNoticeContent']['opened_period_to'] < date("Y-m-d H:i:s", time())) {
							$circularNoticeContent['circularNoticeContentStatus'] = CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_CLOSED;
							break;
						}
					}

					// 閲覧、回答状況を取得
					$flags = $this->CircularNoticeTargetUser->getUserReadReplyFlag((int)$circularNoticeContent['CircularNoticeContent']['id'], $userId);

					// 回答済みである場合は「回答済」
					if ($flags['CircularNoticeTargetUser']['reply_flag']) {
						$circularNoticeContent['circularNoticeContentStatus'] = CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_REPLIED;
					} else {
						// 閲覧済みである場合は「既読」
						if ($flags['CircularNoticeTargetUser']['read_flag']) {
							$circularNoticeContent['circularNoticeContentStatus'] = CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_READ_YET;
						}
						// その他の場合は「未読」
						else {
							$circularNoticeContent['circularNoticeContentStatus'] = CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_UNREAD;
						}
					}
				}
		}
	}

/**
 * __getCircularNoticeContentList method
 *
 * @param string $circularNoticeKey circular_notice.key
 * @param int $userId users.id
 * @param array $permission
 * @param int $status
 * @param int $displayOrder
 * @return array
 */
	private function __getCircularNoticeContentList($circularNoticeKey, $userId, $permission, $status = CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_ALL, $displayOrder = CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_DISPLAY_ORDER_NEW_ARRIVAL)
	{
		// 取得項目の設定
		$fields = array(
			'CircularNoticeContent.id',
			'CircularNoticeContent.status',
			'CircularNoticeContent.subject',
			'CircularNoticeContent.opened_period_from',
			'CircularNoticeContent.opened_period_to',
			'CircularNoticeContent.reply_deadline_set_flag',
			'CircularNoticeContent.reply_deadline',
		);

		// 取得条件の設定
		// 作成権限、編集権限、公開権限がない場合
		if(!$permission['contentPublishable'] || !$permission['contentEditable'] || !$permission['contentCreatable']) {
			// 自身が回覧先に含まれている回覧データのみを取得
			$params['joins'][] = array(
				'type' => 'INNER',
				'table' => 'circular_notice_target_users',
				'alias' => 'CircularNoticeTargetUser',
				'conditions' => array(
					'CircularNoticeTargetUser.user_id = ' . $userId,
					'CircularNoticeContent.id = CircularNoticeTargetUser.circular_notice_content_id',
					'CircularNoticeContent.status = ' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_PUBLISHED,
				),
			);
			// 取得項目を追加
			$fields[] = 'CircularNoticeTargetUser.read_flag';
			$fields[] = 'CircularNoticeTargetUser.reply_flag';
		}

		// 表示順の設定
		$order = null;
		switch($displayOrder) {
			case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_DISPLAY_ORDER_NEW_ARRIVAL:
				$order = array('CircularNoticeContent.modified desc');
				break;
			case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_DISPLAY_ORDER_OLD_ARRIVAL:
				$order = array('CircularNoticeContent.modified asc');
				break;
			case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_DISPLAY_ORDER_REPLY_DEADLINE_DESC:
				$order = array('CircularNoticeContent.reply_deadline desc');
				break;
		}

		// SQL発行時のパラメーターを作成
		$params['fields'] = $fields;
		$params['order'] = $order;
		$params['recursive'] = -1;	// 関連先テーブルのデータは取得しない

		return $this->find('all', $params);
	}

/**
 * getCircularNoticeContentForView method
 *
 * @param int $circularNoticeContentId circular_notice_contents.id
 * @param int $userId users.id
 * @return array
 */
	public function getCircularNoticeContentForView($circularNoticeContentId, $userId)
	{
		// 回覧を取得
		$circularNoticeContent = $this->__getCircularNoticeContent($circularNoticeContentId);
		$circularNoticeContent['CircularNoticeContent']['created_username'] = $circularNoticeContent['User']['username'];

		// 回覧選択肢を取得
		$circularNoticeChoices = $this->CircularNoticeChoice->getCircularNoticeChoice($circularNoticeContentId);

		// 回覧対象ユーザーを取得
		$circularNoticeTargetUsers = $this->CircularNoticeTargetUser->getCircularNoticeTargetUser($circularNoticeContentId ,$userId);

		// 回覧に関する諸件数を取得し、回覧データに追加
		$count = $this->CircularNoticeTargetUser->getCircularNoticeTargetUserCount($circularNoticeContentId);
		$circularNoticeContent['CircularNoticeContent']['circularNoticeTargetCount'] = $count['circularNoticeTargetCount'];
		$circularNoticeContent['CircularNoticeContent']['circularNoticeReadCount'] = $count['circularNoticeReadCount'];
		$circularNoticeContent['CircularNoticeContent']['circularNoticeReplyCount'] = $count['circularNoticeReplyCount'];

		// ログインユーザーの回答を取得
		$answer = $this->CircularNoticeTargetUser->getMyAnswer($circularNoticeContentId, $userId);

		// 回答方式で分岐
		switch ($circularNoticeContent['CircularNoticeContent']['reply_type']) {
			// 「記述式」の場合
			case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT:
				// ログインユーザーの回答を格納
				$circularNoticeContent['CircularNoticeContent']['answer'] = $answer['CircularNoticeTargetUser']['reply_text_value'];
				break;
			// 「択一選択」の場合
			case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION:
				// 選択肢に対する回答件数取得
				foreach ($circularNoticeChoices as &$circularNoticeChoice) {
					$circularNoticeChoice['CircularNoticeChoice']['selectedCount'] =
						$this->CircularNoticeTargetUser->getUserSelectionValue($circularNoticeContentId, $circularNoticeChoice['CircularNoticeChoice']['value']);
				}
				// ログインユーザーの回答を格納
				$circularNoticeContent['CircularNoticeContent']['answer'] = $answer['CircularNoticeTargetUser']['reply_selection_value'];
				break;
			// 「選択方式」の場合
			case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION:
				// 選択肢に対する回答件数取得
				foreach ($circularNoticeChoices as &$circularNoticeChoice) {
					$circularNoticeChoice['CircularNoticeChoice']['selectedCount'] =
						$this->CircularNoticeTargetUser->getUserSelectionValue($circularNoticeContentId, $circularNoticeChoice['CircularNoticeChoice']['value']);
				}
				// ログインユーザーの回答を配列形式で格納
				$circularNoticeContent['CircularNoticeContent']['answer'] = explode(",", $answer['CircularNoticeTargetUser']['reply_selection_value']);
				break;
		}

		// 取得結果を配列に格納
		$result['CircularNoticeContent'] = $circularNoticeContent['CircularNoticeContent'];
		$result['CircularNoticeChoice'] = $circularNoticeChoices;
		$result['CircularNoticeTargetUser'] = $circularNoticeTargetUsers;

		return $result;
	}

/**
 * getCircularNoticeContentForEdit method
 *
 * @param int $circularNoticeContentId circular_notice_contents.id
 * @param int $userId users.id
 * @return array
 */
	public function getCircularNoticeContentForEdit($circularNoticeContentId, $userId = null)
	{
		// 回覧を取得
		$circularNoticeContent = $this->__getCircularNoticeContent($circularNoticeContentId);
		// 回覧選択肢を取得
		$circularNoticeChoices = $this->CircularNoticeChoice->getCircularNoticeChoice($circularNoticeContentId);

		// 取得結果を配列に格納
		$result = null;
		if ($circularNoticeContent) {
			$result['CircularNoticeContent'] = $circularNoticeContent['CircularNoticeContent'];
		}
		if ($circularNoticeChoices) {
			$result['CircularNoticeChoice'] = $circularNoticeChoices;
		}

		return $result;
	}

/**
 * __getCircularNoticeContent method
 *
 * @param int $circularNoticeContentId circular_notice_content.id
 * @return array
 */
	private function __getCircularNoticeContent($circularNotceContentId)
	{
		// 取得条件を設定
		$conditions = array(
			'CircularNoticeContent.id' => $circularNotceContentId,
		);

		// DBから取得した値を返す
		return $this->find('first', array(
			'conditions' => $conditions,
			'recursive' => 1,
		));
	}

/**
 * saveCircularNoticeContent method
 *
 * @param array $data
 * @param int $status
 * @return array
 */
	public function saveCircularNoticeContent($data, $status) {
		// 必要なモデル読み込み
		$this->loadModels([
			'CircularNotice' => 'CircularNotices.CircularNotice',
			'circularNoticeChoices' => 'CircularNotices.CircularNoticeChoice',
			'CircularNoticeTargetUser' => 'CircularNotices.CircularNoticeTargetUser',
		]);

		// 回覧板を取得
		$circularNotice = $this->CircularNotice->getCircularNotice($data['Block']['id']);
		if (! $circularNotice) {
			return;
		}

		// テーブル定義のデフォルト値でレコードを作成（コミットはされない）
		$circularNoticeContent = $this->create(['key' => Security::hash('circularNoticeContent' . mt_rand() . microtime(), 'md5')]);

		// 登録データを作成
		// 回覧板キー
		$circularNoticeContent['CircularNoticeContent']['circular_notice_key'] = $circularNotice['CircularNotice']['key'];

		// 公開状況
		$circularNoticeContent['CircularNoticeContent']['status'] = $status;

		// タイトル
		$circularNoticeContent['CircularNoticeContent']['subject'] = $data['CircularNoticeContent']['subject'];

		// 回覧内容
		$circularNoticeContent['CircularNoticeContent']['content'] = $data['CircularNoticeContent']['content'];

		// 回答方式
		$circularNoticeContent['CircularNoticeContent']['reply_type'] = $data['CircularNoticeContent']['reply_type'];

		// 回覧先ルーム
		$targetUserId = null;
		if ($data['CircularNoticeContent']['is_room_targeted_flag']) {
			$circularNoticeContent['CircularNoticeContent']['is_room_targeted_flag'] = 1;
			$targetUserId = $this->__getTargetUserFromRoom($data['CircularNoticeContent']['is_room_targeted_flag'][0]);
		} else {
			$circularNoticeContent['CircularNoticeContent']['is_room_targeted_flag'] = 0;
		}

		// 回覧先グループ
		if ($data['CircularNoticeContent']['target_groups']) {
			$groups = '';
			foreach ($data['CircularNoticeContent']['target_groups'] as $key => $value) {
				$groups .= $value . ',';
			}
			$circularNoticeContent['CircularNoticeContent']['target_groups'] = substr($groups, 0, -1);
		}

		// 回覧期間（開始日時）
		$opendPeriodFromTime = strtotime($data['CircularNoticeContent']['opened_period_from_date'] . ' '
								. $data['CircularNoticeContent']['opened_period_from_hour'] . ':'
								. $data['CircularNoticeContent']['opened_period_from_minute']);
		$circularNoticeContent['CircularNoticeContent']['opened_period_from'] = date("Y-m-d H:i",$opendPeriodFromTime);

		// 回覧期間（終了日時）
		$opendPeriodToTime = strtotime($data['CircularNoticeContent']['opened_period_to_date'] . ' '
								. $data['CircularNoticeContent']['opened_period_to_hour'] . ':'
								. $data['CircularNoticeContent']['opened_period_to_minute']);
		$circularNoticeContent['CircularNoticeContent']['opened_period_to'] = date("Y-m-d H:i",$opendPeriodToTime);

		// 回答期限設定フラグ
		$circularNoticeContent['CircularNoticeContent']['reply_deadline_set_flag'] = $data['CircularNoticeContent']['reply_deadline_set_flag'];

		// 回答期限を設定する場合
		if ($circularNoticeContent['CircularNoticeContent']['reply_deadline_set_flag'] == 1) {
			// 回答期限
			$replyDeadLineTime = strtotime($data['CircularNoticeContent']['reply_deadline_date'] . ' '
									. $data['CircularNoticeContent']['reply_deadline_hour'] . ':'
									. $data['CircularNoticeContent']['reply_deadline_minute']);
			$circularNoticeContent['CircularNoticeContent']['reply_deadline'] = date("Y-m-d H:i",$replyDeadLineTime);
		}

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			// 回覧を登録
			$circularNoticeContentResult = $this->__saveCircularNoticeContent($circularNoticeContent, false);

			// 回覧対象ユーザーデータ作成
			$circularNoticeTargetUser = null;
			if ($targetUserId) {
				foreach ($targetUserId as $userId) {
					$circularNoticeTargetUser['CircularNoticeTargetUser'][] = array(
						'user_id' => $userId,
						'circular_notice_content_id' => $circularNoticeContentResult['CircularNoticeContent']['id'],
					);
				}
			}
			// 回覧対象ユーザーを登録
			$circularNoticeTargetUserResult = $this->CircularNoticeTargetUser->saveCircularNoticeTargetUser($circularNoticeTargetUser, false);

			$dataSource->commit();
		} catch (Exception $ex) {
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}

		return;
	}

/**
 * saveCircularNoticeContent method
 *
 * @param array $data received post data
 * @param bool|array $validate Either a boolean, or an array.
 *   If a boolean, indicates whether or not to validate before saving.
 *   If an array, can have following keys:
 *
 *   - validate: Set to true/false to enable or disable validation.
 *   - fieldList: An array of fields you want to allow for saving.
 *   - callbacks: Set to false to disable callbacks. Using 'before' or 'after'
 *      will enable only those callbacks.
 *   - `counterCache`: Boolean to control updating of counter caches (if any)
 *
 * @param array $fieldList List of fields to allow to be saved
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function __saveCircularNoticeContent($data, $validate = true, $fieldList = array()) {
		if (!$this->validateCircularNoticeContent($data)) {
			return false;
		}

		$circularNoticeContent = $this->save(null, $validate);
		if (! $circularNoticeContent) {
			// @codeCoverageIgnoreStart
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			// @codeCoverageIgnoreEnd
		}
		return $circularNoticeContent;
	}

/**
 * validateCircularNoticeContent method
 *
 * @param int $circularNoticeContentId circular_notice_content.id
 * @param int $userId users.id
 * @return boolean
 */
	private function __isCreater($circularNoticeContentId, $userId) {
		// 取得条件を設定
		$conditions = array(
			'CircularNoticeContent.id' => $circularNoticeContentId,
			'CircularNoticeContent.created_user' => $userId,
		);

		// 件数を取得
		$count = $this->find('count', array(
			'conditions' => $conditions,
			'recursive' => -1,
		));

		// 回覧作成者ではない場合
		if($count == 0) {
			return false;
		}
		// 回覧作成者である場合
		else {
			return true;
		}
	}

/**
 * validateCircularNoticeContent method
 *
 * @param array $data received post data
 * @return bool True on success, false on error
 */
	private function validateCircularNoticeContent($data) {
		$this->set($data);
		$this->validates();
//		return $this->validationErrors ? false : true;
		return true;
	}

/**
 * __getTargetUserFromRoom method
 *
 * @param int $roomId roles_rooms_users.user_id
 * @return array
 */
	private function __getTargetUserFromRoom($roomId) {
		return array(
			0 => '1',
			1 => '2',
			2 => '3',
			3 => '4',
			4 => '5',
		);
	}
}
