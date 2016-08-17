<?php
/**
 * CircularNotice Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');

/**
 * CircularNotice Component
 *
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @package NetCommons\CircularNotices\Controller\Component
 */
class CircularNoticeComponent extends Component {

/**
 * view status published
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_PUBLISHED = WorkflowComponent::STATUS_PUBLISHED;

/**
 * view in draft status
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_IN_DRAFT = WorkflowComponent::STATUS_IN_DRAFT;

/**
 * view status reserved
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_RESERVED = '5';

/**
 * view status open
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_OPEN = '6';

/**
 * view status fixed
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_FIXED = '7';

/**
 * view status closed
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_CLOSED = '8';

/**
 * view status unread
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_UNREAD = '10';

/**
 * view status read yet
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_READ_YET = '11';

/**
 * view status replied
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_REPLIED = '12';

/**
 * view status not replied
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_NOT_REPLIED = '13';

/**
 * reply by text
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT = '1';

/**
 * reply by selection
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION = '2';

/**
 * reply by multiple selection
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION = '3';

/**
 * reply selection values delimiter
 *
 * @var string
 */
	const SELECTION_VALUES_DELIMITER = '|';

/**
 * export target users file extension
 *
 * @var string
 */
	const EXPORT_FILE_EXTENSION = '.csv';

/**
 * export target users compress file extension
 *
 * @var string
 */
	const EXPORT_COMPRESS_FILE_EXTENSION = '.zip';

/**
 * 回覧先のヘッダ項目を取得
 *
 * @return array
 */
	public function getTargetUserHeader() {
		return array(
			h(__d('circular_notices', 'Target User')),
			h(__d('circular_notices', 'Read Datetime')),
			h(__d('circular_notices', 'Reply Datetime')),
			h(__d('circular_notices', 'Answer'))
		);
	}

/**
 * 表示用日付フォーマットを取得
 *
 * @param string $dateTime date time
 * @return array
 */
	public function getDisplayDateFormat($dateTime) {
		App::import('Helper', 'NetCommons.Date');
		$dateHelper = new DateHelper(new View());
		return $dateHelper->dateFormat($dateTime);
	}

/**
 * 選択済みユーザを設定
 * 
 * @param Controller $controller コントローラ
 * @return {void}
 */
	public function setSelectUsers(Controller $controller) {
		$controller->request->data['selectUsers'] = array();
		if (isset($controller->request->data['CircularNoticeTargetUser'])) {
			$selectUsers =
				Hash::extract($controller->request->data['CircularNoticeTargetUser'], '{n}.user_id');
			foreach ($selectUsers as $userId) {
				$user = $controller->User->getUser($userId);
				$controller->request->data['selectUsers'][] = $user;
			}
		}
	}

/**
 * エラー内容を保持
 * 
 * @param Controller $controller コントローラー
 * @return void
 */
	public function setCircularNoticeErrors(Controller $controller) {
		if ($controller->Session->read('circularNoticeErrors')) {
			foreach ($controller->Session->read('circularNoticeErrors') as $model => $errors) {
				if (! $controller->$model) {
					$controller->loadModel($model);
				}
				$controller->$model->validationErrors = $errors;
			}
			$controller->Session->delete('circularNoticeErrors');
		}
	}

/**
 * データを保持
 *
 * @param Controller $controller コントローラー
 * @return void
 */
	public function setCircularNoticeDatas(Controller $controller) {
		if ($controller->Session->read('circularNoticeDatas')) {
			$controller->set('circularNoticeDatas', $controller->Session->read('circularNoticeDatas'));
			$controller->Session->delete('circularNoticeDatas');
		}
	}

/**
 * コンテンツステータスの選択値存在チェック
 *
 * @param string $checkValue チェック対象値
 * @return bool チェック結果（true:存在する, false:存在しない）
 */
	public function existsContentStatus($checkValue) {
		$contentStatusArr = array(
			CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_PUBLISHED,
			CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_IN_DRAFT,
			CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_RESERVED,
			CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_OPEN,
			CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_FIXED,
			CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_CLOSED,
		);
		return in_array($checkValue, $contentStatusArr, true);
	}

/**
 * 回答状況の選択値存在チェック
 *
 * @param string $checkValue チェック対象値
 * @return bool チェック結果（true:存在する, false:存在しない）
 */
	public function existsReplyStatus($checkValue) {
		$contentStatusArr = array(
			CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_REPLIED,
			CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_NOT_REPLIED,
		);
		return in_array($checkValue, $contentStatusArr, true);
	}
}
