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

$curretSort = isset($this->Paginator->params['named']['sort']) ? $this->Paginator->params['named']['sort'] : 'CircularNoticeContent.created';
$curretDirection = isset($this->Paginator->params['named']['direction']) ? $this->Paginator->params['named']['direction'] : 'desc';

$options = array(
	'CircularNoticeContent.created.desc' => array(
		'label' => __d('circular_notices', 'Change Sort Order to New Arrival'),
		'sort' => 'CircularNoticeContent.created',
		'direction' => 'desc'
	),
	'CircularNoticeContent.created.asc' => array(
		'label' => __d('circular_notices', 'Change Sort Order to Old Arrival'),
		'sort' => 'CircularNoticeContent.created',
		'direction' => 'asc'
	),
	'CircularNoticeContent.reply_deadline.desc' => array(
		'label' => __d('circular_notices', 'Change Sort Order to Reply Deadline'),
		'sort' => 'CircularNoticeContent.reply_deadline',
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
