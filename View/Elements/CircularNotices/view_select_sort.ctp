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
	array('controller' => 'circular_notices', 'action' => 'view', $frameId, $circularNoticeContent['id']),
	$this->Paginator->params['named'],
	['page' => 1]
);

$curretSort = isset($this->Paginator->params['named']['sort']) ? $this->Paginator->params['named']['sort'] : 'User.username';
$curretDirection = isset($this->Paginator->params['named']['direction']) ? $this->Paginator->params['named']['direction'] : 'asc';

$options = array(
	'User.username.asc' => array(
		'label' => __d('circular_notices', 'Target User (Ascending)'),
		'sort' => 'User.username',
		'direction' => 'asc'
	),
	'User.username.desc' => array(
		'label' => __d('circular_notices', 'Target User (Descending)'),
		'sort' => 'User.username',
		'direction' => 'desc'
	),
	'CircularNoticeTargetUser.reply_text_value.asc' => array(
		'label' => __d('circular_notices', 'Answer (Ascending)'),
		'sort' => 'CircularNoticeTargetUser.reply_text_value',
		'direction' => 'asc'
	),
	'CircularNoticeTargetUser.reply_text_value.desc' => array(
		'label' => __d('circular_notices', 'Answer (Descending)'),
		'sort' => 'CircularNoticeTargetUser.reply_text_value',
		'direction' => 'desc'
	),
	'CircularNoticeTargetUser.reply_datetime.asc' => array(
		'label' => __d('circular_notices', 'Reply Datetime (Ascending)'),
		'sort' => 'CircularNoticeTargetUser.reply_datetime',
		'direction' => 'asc'
	),
	'CircularNoticeTargetUser.reply_datetime.desc' => array(
		'label' => __d('circular_notices', 'Reply Datetime (Descending)'),
		'sort' => 'CircularNoticeTargetUser.reply_datetime',
		'direction' => 'desc'
	),
);
?>

<span class="btn-group">
	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo h($options[$curretSort . '.' . $curretDirection]['label']); ?>
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<?php foreach ($options as $key => $sort) : ?>
			<li>
				<?php echo $this->Paginator->link($sort['label'], array('sort' => $sort['sort'], 'direction' => $sort['direction']), array('url' => $url)); ?>
			</li>
		<?php endforeach; ?>
	</ul>
</span>
