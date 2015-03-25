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

/**
 * CircularNoticeContent Model
 */
class CircularNoticeContent extends CircularNoticesAppModel {

//	// 定数定義
//	const CIRCULAR_NOTICE_CONTENT_STATUS_ALL = 0;				// 全てのステータスを表示
//	const CIRCULAR_NOTICE_CONTENT_STATUS_PUBLIC = 1;			// 公開中
//	const CIRCULAR_NOTICE_CONTENT_STATUS_PUBLIC_PENDING = 2;	// 承認待ち
//	const CIRCULAR_NOTICE_CONTENT_STATUS_DRAFT_DURING = 3;		// 一時保存
//	const CIRCULAR_NOTICE_CONTENT_STATUS_REMAND = 4;			// 差し戻し
//	const CIRCULAR_NOTICE_CONTENT_STATUS_RESERVED = 5;			// 公開前
//	const CIRCULAR_NOTICE_CONTENT_STATUS_OPEN = 5;				// 回覧中
//	const CIRCULAR_NOTICE_CONTENT_STATUS_FIXED = 6;				// 回答受付終了
//	const CIRCULAR_NOTICE_CONTENT_STATUS_CLOSED = 7;			// 回覧終了
//	const CIRCULAR_NOTICE_CONTENT_STATUS_UNREAD = 10;			// 未読
//	const CIRCULAR_NOTICE_CONTENT_STATUS_READ_YET = 11;			// 既読
//	const CIRCULAR_NOTICE_CONTENT_STATUS_REPLIED = 12;			// 回答済
//
//	const CIRCULAR_NOTICE_CONTENT_DISPLAY_ORDER_NEW_ARRIVAL = 0;			// 新着順（降順）
//	const CIRCULAR_NOTICE_CONTENT_DISPLAY_ORDER_OLD_ARRIVAL = 1;			// 新着順（降順）
//	const CIRCULAR_NOTICE_CONTENT_DISPLAY_ORDER_REPLY_DEADLINE_DESC = 2;	// 回答期限順（降順）

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
//		'CircularNoticeChoice' => array(
//			'className' => 'CircularNotices.CircularNoticeChoice',
//			'foreignKey' => 'content_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		)
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
		// 必要なモデル読み込み
		$this->loadModels([
			'CircularNoticeTargetUser' => 'CircularNotices.CircularNoticeTargetUser',
		]);

		// 回覧一覧で使用する項目を取得
		$circularNoticeContents = $this->__getCircularNoticeContent($circularNoticeKey, $userId, $permission, $status, $displayOrder);

		foreach($circularNoticeContents as &$circularNoticeContent) {
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
					// 回覧期間（開始日時）前の場合は「公開前」
					if($circularNoticeContent['CircularNoticeContent']['opened_period_from'] < date( "Y/m/d H:i:s", time() )) {
						$circularNoticeContent['circularNoticeContentStatus'] = CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_RESERVED;
						break;
					}

					// 回覧先に含まれている場合
					if(is_set($circularNoticeContent['CircularNoticeTargetUser'])) {

					}
					// 回覧先に含まれていない場合（作成者）
					else {

					}
			}

			// 回覧に関する諸件数を取得
			$count = $this->CircularNoticeTargetUser->getCircularNoticeTargetUserCount((int)$circularNoticeContent['CircularNoticeContent']['id']);

			// 回覧データに追加
			$circularNoticeContent['circularNoticeTargetCount'] = $count['circularNoticeTargetCount'];
			$circularNoticeContent['circularNoticeReadCount'] = $count['circularNoticeReadCount'];
			$circularNoticeContent['circularNoticeReplyCount'] = $count['circularNoticeReplyCount'];
		}

		print_r($circularNoticeContents);

		return $circularNoticeContents;
	}


/**
 * __getCircularNoticeContent method
 *
 * @param string $circularNoticeKey circular_notice.key
 * @param int $userId users.id
 * @param array $permission
 * @param int $status
 * @param int $displayOrder
 * @return array
 */
	public function __getCircularNoticeContent($circularNoticeKey, $userId, $permission, $status = CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_ALL, $displayOrder = CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_DISPLAY_ORDER_NEW_ARRIVAL)
	{
		// 同一のキーで最新のデータのみを取得するため、サブクエリを作成
		$db = $this->getDataSource();
		$subQuery = $db->buildStatement(
			array(
				// 取得対象はIDの最大値
				'fields' => array(
					'MAX(CircularNoticeContent2.id)'
				),
				'table' => 'circular_notice_contents',
				'alias' => 'CircularNoticeContent2',
				'conditions' => array(
					'CircularNoticeContent2.circular_notice_key' => $circularNoticeKey
				),
				'order' => null,
				// キーでグルーピング
				'group' => 'CircularNoticeContent2.key',
			), $this
		);

		$subQuery = ' CircularNoticeContent.id in (' . $subQuery . ') ';
		$subQueryExpression = $db->expression($subQuery);
		$conditions[] = $subQueryExpression;

		// サブクエリを配列に格納
		$params = compact('conditions');

		// 取得項目の設定
		$fields = array(
			'CircularNoticeContent.id',
			'CircularNoticeContent.status',
			'CircularNoticeContent.subject',
			'CircularNoticeContent.opened_period_from',
			'CircularNoticeContent.opened_period_to',
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
//
//		$this->log($db->getLog(), 'trace');
//		$this->log(print_r($result, true), 'trace');
	}

/**
 * getSelectOption method
 *
 * @param int $contentCreatable
 * @return array
 */
	public function getSelectOption($contentCreatable)
	{
		// ステータスにより絞り込み値
		$contentStatus = null;

		// コンテンツ作成権限がない場合
		if(!$contentCreatable) {
			$contentStatus = array(
				// 全てのステータスを表示
				array(
					'num' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_ALL,
					'label' => __d('circular_notices', 'Display All Contents')
				),
				// 未読
				array(
					'num' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_UNREAD,
					'label' => __d('circular_notices', 'Display Unread Contents')
				),
				// 既読
				array(
					'num' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_READ_YET,
					'label' => __d('circular_notices', 'Display Read Yet Contents')
				),
				// 回答済
				array(
					'num' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_REPLIED,
					'label' => __d('circular_notices', 'Display Replied Contents')
				),
				// 回答受付終了
				array(
					'num' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_FIXED,
					'label' => __d('circular_notices', 'Display Fixed Contents')
				),
			);
		}
		// コンテンツ作成権限がある場合
		else {
			$contentStatus = array(
				// 全てのステータスを表示
				array(
					'num' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_ALL,
					'label' => __d('circular_notices', 'Display All Contents')
				),
				// 承認待ち
				array(
					'num' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_APPROVED,
					'label' => __d('circular_notices', 'Display Public Pending Contents')
				),
				// 一時保存
				array(
					'num' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_IN_DRAFT,
					'label' => __d('circular_notices', 'Display Draft During Contents')
				),
				// 差し戻し
				array(
					'num' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_DISAPPROVED,
					'label' => __d('circular_notices', 'Display Remand Contents')
				),
				// 公開前
				array(
					'num' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_RESERVED,
					'label' => __d('circular_notices', 'Display Reserved Contents')
				),
				// 回覧中
				array(
					'num' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_OPEN,
					'label' => __d('circular_notices', 'Display Open Contents')
				),
				// 回答受付終了
				array(
					'num' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_FIXED,
					'label' => __d('circular_notices', 'Display Fixed Contents')
				),
				// 回覧終了
				array(
					'num' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_CLOSED,
					'label' => __d('circular_notices', 'Display Closed Contents')
				),
				// 未読
				array(
					'num' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_UNREAD,
					'label' => __d('circular_notices', 'Display Unread Contents')
				),
				// 既読
				array(
					'num' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_READ_YET,
					'label' => __d('circular_notices', 'Display Read Yet Contents')
				),
				// 回答済
				array(
					'num' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_REPLIED,
					'label' => __d('circular_notices', 'Display Replied Contents')
				),
			);
		}

		// 並び替え値
		$displayOrder = array(
			// 新着順（降順）
			array(
				'num' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_DISPLAY_ORDER_NEW_ARRIVAL,
				'label' => __d('circular_notices', 'Change Sort Order to New Arrival')
			),
			// 新着順（降順）
			array(
				'num' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_DISPLAY_ORDER_OLD_ARRIVAL,
				'label' => __d('circular_notices', 'Change Sort Order to Old Arrival')
			),
			// 回答期限順（降順）
			array(
				'num' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_DISPLAY_ORDER_REPLY_DEADLINE_DESC,
				'label' => __d('circular_notices', 'Change Sort Order to Reply Deadline')
			),
		);

		// 絞り込み値、並び替え値をまとめて返す
		return array(
			'contentStatus' => $contentStatus,
			'displayOrder' => $displayOrder
		);
	}

/**
 * getCircularNoticeContent method
 *
 * @param int $circularNoticeContentId circular_notice_content.id
 * @return array
 */
	public function getCircularNoticeContent($circularNotceContentId)
	{
		// 取得条件を設定
		$conditions = array(
			'CircularNoticeContent.id' => $circularNotceContentId,
		);

		// DBから取得した値を返す
		return $this->find('first', array(
			'conditions' => $conditions,
		));

	}
}
