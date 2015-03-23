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
App::uses('Component', 'NetCommonsBlock');

/**
 * CircularNotices Component
 *
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @package NetCommons\CircularNotices\Controller\Component
 */
class CircularNoticeComponent extends Component {

/**
 * all status
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_ALL = '0';

/**
 * status published
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_PUBLISHED = NetCommonsBlockComponent::STATUS_PUBLISHED;

/**
 * status approved
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_APPROVED = NetCommonsBlockComponent::STATUS_APPROVED;

/**
 * in draft status
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_IN_DRAFT = NetCommonsBlockComponent::STATUS_IN_DRAFT;

/**
 * status disapproved
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_DISAPPROVED = NetCommonsBlockComponent::STATUS_DISAPPROVED;

/**
 * status reserved
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_RESERVED = '5';

/**
 * status open
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_OPEN = '5';

/**
 * status fixed
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_FIXED = '6';

/**
 * status closed
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_CLOSED = '7';

/**
 * status unread
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_UNREAD = '10';

/**
 * status read yet
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_READ_YET = '11';

/**
 * status replied
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_REPLIED = '12';

/**
 * order by new arrival
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_DISPLAY_ORDER_NEW_ARRIVAL = '0';

/**
 * order by old arrival
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_DISPLAY_ORDER_OLD_ARRIVAL = '1';

/**
 * order by reply deadline descending
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_DISPLAY_ORDER_REPLY_DEADLINE_DESC = '2';

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
	 * use component
	 *
	 * @var array
	 */
	public $components = array(
		'Session',
	);

//	/**
//	 * setCircularNoticeFrameSettingToSession method
//	 *
//	 * @param int $frameId frames.id
//	 * @param int $blockId blocks.id
//	 * @param int $displayNumber circular_notice_frame_settings.display_number
//	 * @param int $currentPage select page
//	 * @return void
//	 */
//	public function setCircularNoticeFrameSettingToSession($frameId, $blockId, $displayNumber, $currentPage = 1) {
//		// セッション保存
//		$this->Session->write('circularNotices.' . $frameId . '.' . $blockId . '.displayNumber', $displayNumber);
//		$this->Session->write('circularNotices.' . $frameId . '.' . $blockId . '.currentPage', $currentPage);
//	}



}
