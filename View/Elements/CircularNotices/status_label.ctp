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
$status = $circularNoticeContent['current_status'];
if (
	$status == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_OPEN &&
	isset($circularNoticeContent['user_status'])
) :
	$status = $circularNoticeContent['user_status'];
endif;

$labels = [
	CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_IN_DRAFT => [
		'class' => 'workflow-label circular-notice-status-label label-info',
		'message' => __d('net_commons', 'Temporary'),
	],
	CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_RESERVED => [
		'class' => 'workflow-label circular-notice-status-label label-success',
		'message' => __d('circular_notices', 'Reserved'),
	],
	CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_OPEN => [
		'class' => 'workflow-label circular-notice-status-label label-primary',
		'message' => __d('circular_notices', 'Open'),
	],
	CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_FIXED => [
		'class' => 'workflow-label circular-notice-status-label label-default',
		'message' => __d('circular_notices', 'Fixed'),
	],
	CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_CLOSED => [
		'class' => 'workflow-label circular-notice-status-label label-default',
		'message' => __d('circular_notices', 'Closed'),
	],
	CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_UNREAD => [
		'class' => 'workflow-label circular-notice-status-label label-danger',
		'message' => __d('circular_notices', 'Unread'),
	],
	CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_READ_YET => [
		'class' => 'workflow-label circular-notice-status-label label-info',
		'message' => __d('circular_notices', 'Read Yet'),
	],
	CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_REPLIED => [
		'class' => 'workflow-label circular-notice-status-label label-success',
		'message' => __d('circular_notices', 'Replied'),
	],
];
$label = isset($labels[$status]) ? $labels[$status] : null;
?>

<?php if ($label): ?>
	<span class="workflow-label label label-info <?php echo h($labels[$status]['class']); ?>">
		<?php echo h($labels[$status]['message']); ?>
	</span>
<?php endif;
