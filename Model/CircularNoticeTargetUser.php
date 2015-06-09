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
 * Use behaviors
 *
 * @var array
 */
	public $actAs = array();

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
		)
	);

/**
 * Get count of circular notice target user
 *
 * @param int $contentId
 * @return array
 */
	public function getCircularNoticeTargetUserCount($contentId)
	{
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
 * @param int $contentId
 * @param int $userId
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
 * @param int $contentId
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
 * @param int $contentId
 * @param array $paginatorParams
 * @param int $userId
 * @return array
 */
	public function getCircularNoticeTargetUsersForPaginator($contentId, $paginatorParams, $userId) {

		// ログイン者を先頭に持ってくるためにfieldsをカスタム
		$fields = array(
			'*',
			'(CASE WHEN CircularNoticeTargetUser.user_id = \'' . $userId . '\' THEN 1 ELSE 2 END) AS my_order',
		);

		$conditions = array(
			'CircularNoticeTargetUser.circular_notice_content_id' => $contentId,
		);

		// 表示順
		$order =  array('User.username' => 'asc');
		if (isset($paginatorParams['sort']) && isset($paginatorParams['direction'])) {
			$order = array($paginatorParams['sort'] => $paginatorParams['direction']);
		}

		// 表示件数
		$limit = self::DEFAULT_DISPLAY_NUMBER;
		if (isset($paginatorParams['limit'])) {
			$limit = (int)$paginatorParams['limit'];
		}

		return array(
			'fields' => $fields,
			'recursive' => 0,
			'conditions' => $conditions,
			'order' => $order,
			'limit' => $limit,
		);
	}

/**
 * Hook for Paginator's paginate
 *
 * @param array $conditions
 * @param array $fields
 * @param array $order
 * @param int $limit
 * @param int $page
 * @param int $recursive
 * @param array $extra
 * @return mixed
 */
	public function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) {

		// ログイン者を先頭に持ってくるためにorderをカスタム
		$customOrder = array(array('my_order' => 'asc'));
		if (! empty($order)) {
			$customOrder[] = $order;
		}
		$order = $customOrder;

		return $this->find('all', compact('conditions', 'fields', 'order', 'limit', 'page', 'recursive'));
	}

/**
 * Save for read
 *
 * @param int $id
 * @return bool
 * @throws Exception
 * @throws InternalErrorException
 */
	public function saveRead($id) {

		$data = array(
			'CircularNoticeTargetUser' => array(
				'id' => $id,
				'read_flag' => true,
				'read_datetime' => date('Y-m-d H:i:s'),
			)
		);

		if (! $this->saveCircularNoticeTargetUser($data)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return true;
	}

/**
 * Save circular notice target user
 *
 * @param array $data
 * @return bool
 * @throws Exception
 * @throws InternalErrorException
 */
	public function saveCircularNoticeTargetUser($data) {

		// FIXME: これがあるとページネーションでこけてしまうため回避方法を探す
//		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {

			// データセット＋検証
			if (! $this->__validateCircularNoticeTargetUser($data)) {
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
 * @param array $data
 */
	public function replaceCircularNoticeTargetUsers($data) {

		$contentId = $data['CircularNoticeContent']['id'];

		// すべてDelete
		if (! $this->deleteAll(array('CircularNoticeTargetUser.circular_notice_content_id' => $contentId), false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		// 1件ずつ保存
		foreach ($data['CircularNoticeTargetUsers'] as $targetUser) {

			$targetUser['CircularNoticeTargetUser']['circular_notice_content_id'] = $contentId;

			if (! $this->__validateCircularNoticeTargetUser($targetUser)) {
				return false;
			}

			if (! $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		return true;
	}

/**
 * Validate this model
 *
 * @param array $data
 * @return bool
 */
	private function __validateCircularNoticeTargetUser($data) {
		$this->set($data);
		$this->validates();
		return $this->validationErrors ? false : true;
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
