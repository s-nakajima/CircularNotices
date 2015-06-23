<?php
/**
 * circular notice select limit for index element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$url = Hash::merge(
	array('controller' => 'circular_notices', 'action' => 'index', $frameId),
	$this->Paginator->params['named'],
	['page' => 1]
);
$options = CircularNoticeFrameSetting::getDisplayNumberOptions();
$currentLimit = $this->Paginator->param('limit') ? $this->Paginator->param('limit') : CircularNoticeFrameSetting::DEFAULT_DISPLAY_NUMBER;
?>

<span class="btn-group">
	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo h($options[$currentLimit]); ?>
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<?php foreach ($options as $count => $label) : ?>
			<li<?php echo (int)$this->Paginator->param('limit') === $count ? ' class="active"' : ''; ?>>
				<?php echo $this->Paginator->link($label, array('limit' => $count), array('url' => $url)); ?>
			</li>
		<?php endforeach; ?>
	</ul>
</span>
