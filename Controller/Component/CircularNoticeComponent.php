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
 * view all status
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_ALL = '0';

/**
 * view status published
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_PUBLISHED = NetCommonsBlockComponent::STATUS_PUBLISHED;

/**
 * view status approved
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_APPROVED = NetCommonsBlockComponent::STATUS_APPROVED;

/**
 * view in draft status
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_IN_DRAFT = NetCommonsBlockComponent::STATUS_IN_DRAFT;

/**
 * view status disapproved
 *
 * @var string
 */
	const CIRCULAR_NOTICE_CONTENT_STATUS_DISAPPROVED = NetCommonsBlockComponent::STATUS_DISAPPROVED;

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
}
