<?php
/**
 * circular notice select status for view element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$params = $this->params['named'];
$params['page'] = 1;
$url = array_merge(array(
	'controller' => 'circular_notices',
	'action' => 'index'),
	$params);

$contentStatus = isset($this->Paginator->params['named']['content_status']) ? $this->Paginator->params['named']['content_status'] : '';

$options = array(
	'CircularNoticeContents.content_status_' => array(
		'label' => __d('circular_notices', 'Display All Contents'),
		'content_status' => null,
	),
);
// コンテンツ作成権限がある場合
if (Current::permission('content_creatable')) :
	$options = array_merge_recursive($options, array(
		'CircularNoticeContents.content_status_' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_IN_DRAFT => array(
			'label' => __d('circular_notices', 'Display Draft During Contents'),
			'content_status' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_IN_DRAFT,
		),
		'CircularNoticeContents.content_status_' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_RESERVED => array(
			'label' => __d('circular_notices', 'Display Reserved Contents'),
			'content_status' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_RESERVED,
		),
	));
endif;
$options = array_merge_recursive($options, array(
	'CircularNoticeContents.content_status_' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_OPEN => array(
		'label' => __d('circular_notices', 'Display Open Contents'),
		'content_status' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_OPEN,
	),
	'CircularNoticeContents.content_status_' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_FIXED => array(
		'label' => __d('circular_notices', 'Display Fixed Contents'),
		'content_status' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_FIXED,
	),
	'CircularNoticeContents.content_status_' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_CLOSED => array(
		'label' => __d('circular_notices', 'Display Closed Contents'),
		'content_status' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_CLOSED,
	),
));
?>

<span class="btn-group">
	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo h($options['CircularNoticeContents.content_status_' . $contentStatus]['label']); ?>
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<?php foreach ($options as $key => $status) : ?>
			<li>
				<?php echo $this->NetCommonsHtml->link($status['label'],
					array_merge($url, array('content_status' => $status['content_status']))
				); ?>
			</li>
		<?php endforeach; ?>
	</ul>
</span>
