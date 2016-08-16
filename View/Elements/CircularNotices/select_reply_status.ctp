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
$url = Hash::merge(array(
	'controller' => 'circular_notices',
	'action' => 'index'),
	$params);

$userStatus = isset($this->Paginator->params['named']['reply_status']) ? $this->Paginator->params['named']['reply_status'] : '';

$options = array(
	'CircularNoticeContents.reply_status_' => array(
		'label' => __d('circular_notices', 'Display All Reply Status'),
		'reply_status' => null,
	),
	'CircularNoticeContents.reply_status_' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_NOT_REPLIED => array(
		'label' => __d('circular_notices', 'Unreply'),
		'reply_status' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_NOT_REPLIED,
	),
	'CircularNoticeContents.reply_status_' . CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_REPLIED => array(
		'label' => __d('circular_notices', 'Display Replied Contents'),
		'reply_status' => CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_REPLIED,
	),
);
?>

<span class="btn-group">
	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo h($options['CircularNoticeContents.reply_status_' . $userStatus]['label']); ?>
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<?php foreach ($options as $key => $status) : ?>
			<li>
				<?php echo $this->NetCommonsHtml->link($status['label'],
					Hash::merge($url, array('reply_status' => $status['reply_status']))
				); ?>
			</li>
		<?php endforeach; ?>
	</ul>
</span>
