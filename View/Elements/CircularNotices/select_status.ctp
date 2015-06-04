<?php
/**
 * CircularNotices view template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$url = Hash::merge(
	array('controller' => 'circular_notices', 'action' => 'index', $frameId),
	$this->Paginator->params['named'],
	['page' => 1]
);

$currentStatus = isset($this->Paginator->params['named']['status']) ? $this->Paginator->params['named']['status'] : '';

$options = array();

// コンテンツ作成権限がない場合
if (! $contentCreatable) {
	$options = array(
		'CircularNoticeContents.status_' => array(
			'label' => __d('circular_notices', 'Display All Contents'),
			'status' => null,
		),
		'CircularNoticeContents.status_' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_UNREAD => array(
			'label' => __d('circular_notices', 'Display Unread Contents'),
			'status' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_UNREAD,
		),
		'CircularNoticeContents.status_' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_READ_YET => array(
			'label' => __d('circular_notices', 'Display Read Yet Contents'),
			'status' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_READ_YET,
		),
		'CircularNoticeContents.status_' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_REPLIED => array(
			'label' => __d('circular_notices', 'Display Replied Contents'),
			'status' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_REPLIED,
		),
		'CircularNoticeContents.status_' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_FIXED => array(
			'label' => __d('circular_notices', 'Display Fixed Contents'),
			'status' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_FIXED,
		),
	);

// コンテンツ作成権限がある場合
} else {
	$options = array(
		'CircularNoticeContents.status_' => array(
			'label' => __d('circular_notices', 'Display All Contents'),
			'status' => null,
		),
		'CircularNoticeContents.status_' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_IN_DRAFT => array(
			'label' => __d('circular_notices', 'Display Draft During Contents'),
			'status' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_IN_DRAFT,
		),
		'CircularNoticeContents.status_' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_RESERVED => array(
			'label' => __d('circular_notices', 'Display Reserved Contents'),
			'status' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_RESERVED,
		),
		'CircularNoticeContents.status_' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_OPEN => array(
			'label' => __d('circular_notices', 'Display Open Contents'),
			'status' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_OPEN,
		),
		'CircularNoticeContents.status_' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_FIXED => array(
			'label' => __d('circular_notices', 'Display Fixed Contents'),
			'status' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_FIXED,
		),
		'CircularNoticeContents.status_' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_CLOSED => array(
			'label' => __d('circular_notices', 'Display Closed Contents'),
			'status' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_CLOSED,
		),
		'CircularNoticeContents.status_' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_UNREAD => array(
			'label' => __d('circular_notices', 'Display Unread Contents'),
			'status' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_UNREAD,
		),
		'CircularNoticeContents.status_' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_READ_YET => array(
			'label' => __d('circular_notices', 'Display Read Yet Contents'),
			'status' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_READ_YET,
		),
		'CircularNoticeContents.status_' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_REPLIED => array(
			'label' => __d('circular_notices', 'Display Replied Contents'),
			'status' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_REPLIED,
		),
	);
}
?>

<span class="btn-group">
	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo h($options['CircularNoticeContents.status_' . $currentStatus]['label']); ?>
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<?php foreach ($options as $key => $status) : ?>
			<li>
				<?php echo $this->Paginator->link($status['label'],
						array('status' => $status['status']),
						array('url' => $url)
					); ?>
			</li>
		<?php endforeach; ?>
	</ul>
</span>
