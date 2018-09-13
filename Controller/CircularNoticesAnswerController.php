<?php
/**
 * CircularNoticesAnswer Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CircularNoticesAppController', 'CircularNotices.Controller');

/**
 * CircularNotices Controller
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Controller
 */
class CircularNoticesAnswerController extends CircularNoticesAppController {

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'CircularNotices.CircularNoticeContent',
		'CircularNotices.CircularNoticeTargetUser',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.Permission' => array(
			//アクセスの権限
			'allow' => array(
				'edit' => 'content_readable',
			),
		),
		'CircularNotices.CircularNotice',
		'Session',
	);

/**
 * beforeFilters
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
	}

/**
 * edit action
 *
 * @return void
 */
	public function edit() {
		$userId = Current::read('User.id');
		$contentKey = $this->request->params['key'];

		// 回覧を取得
		$content = $this->CircularNoticeContent->getCircularNoticeContent($contentKey, $userId);
		if (! $content) {
			return $this->throwBadRequest();
		}

		if ($this->request->is(array('post', 'put'))) {
			$replyTextValue = '';
			$replySelectionValue = '';
			if ($content['CircularNoticeContent']['reply_type'] ==
				CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT) {
				$replyTextValue = $this->request->data['CircularNoticeTargetUser']['reply_text_value'];
			} elseif ($content['CircularNoticeContent']['reply_type'] ==
				CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION) {
				$replySelectionValue =
					$this->request->data['CircularNoticeTargetUser']['reply_selection_value'];
			} elseif ($content['CircularNoticeContent']['reply_type'] ==
				CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION) {
				if ($this->request->data['CircularNoticeTargetUser']['reply_selection_value']) {
					$replySelectionValue = implode(CircularNoticeComponent::SELECTION_VALUES_DELIMITER,
						$this->request->data['CircularNoticeTargetUser']['reply_selection_value']);
				}
			}

			$data = $this->params['data'];
			$data['CircularNoticeTargetUser'] = array_merge(
				$this->params['data']['CircularNoticeTargetUser'],
				[
					'is_reply' => true,
					'reply_datetime' => date('Y-m-d H:i:s'),
					'reply_text_value' => $replyTextValue,
					'reply_selection_value' => $replySelectionValue
				]
			);

			if ($this->CircularNoticeTargetUser->saveCircularNoticeTargetUser($data)) {
				//新着データを回答済みにする
				$this->CircularNoticeContent->saveTopicUserStatus($content, true);
			}

			$this->NetCommons->handleValidationError($this->CircularNoticeTargetUser->validationErrors);
			if (!empty($this->CircularNoticeTargetUser->validationErrors)) {
				$this->Session->write('circularNoticeErrors.CircularNoticeTargetUser',
					$this->CircularNoticeTargetUser->validationErrors);
				$this->Session->write('circularNoticeDatas', $this->request->data);
			} else {
				$message = __d('circular_notices', 'Answerd.');
				$this->NetCommons->setFlashNotification(
					$message, array('class' => 'success')
				);
			}
		}

		// 元の画面を表示
		$this->redirect($this->request->referer());
	}
}
