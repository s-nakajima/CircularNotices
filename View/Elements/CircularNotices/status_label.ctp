<?php
/**
 * circular notice status label for index element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
$status = $circularNoticeContent['circularNoticeContent']['currentStatus'];
if (
	$status == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_OPEN &&
	isset($circularNoticeContent['circularNoticeContent']['userStatus'])
) :
	$status = $circularNoticeContent['circularNoticeContent']['userStatus'];
endif;

$labels = [
	CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_IN_DRAFT => [
		'class' => 'circular-notice-status-label label-info',
		'message' => __d('net_commons', 'Temporary'),
	],
	CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_RESERVED => [
		'class' => 'circular-notice-status-label label-success',
		'message' => __d('circular_notices', 'Reserved'),
	],
	CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_OPEN => [
		'class' => 'circular-notice-status-label label-primary',
		'message' => __d('circular_notices', 'Open'),
	],
	CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_FIXED => [
		'class' => 'circular-notice-status-label label-default',
		'message' => __d('circular_notices', 'Fixed'),
	],
	CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_CLOSED => [
		'class' => 'circular-notice-status-label label-default',
		'message' => __d('circular_notices', 'Closed'),
	],
	CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_UNREAD => [
		'class' => 'circular-notice-status-label label-danger',
		'message' => __d('circular_notices', 'Unread'),
	],
	CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_READ_YET => [
		'class' => 'circular-notice-status-label label-info',
		'message' => __d('circular_notices', 'Read Yet'),
	],
	CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_REPLIED => [
		'class' => 'circular-notice-status-label label-success',
		'message' => __d('circular_notices', 'Replied'),
	],
];
$label = isset($labels[$status]) ? $labels[$status] : null;
?>

<?php if ($label): ?>
	<span class="label <?php echo h($labels[$status]['class']); ?>">
		<?php echo h($labels[$status]['message']); ?>
	</span>
<?php endif;
