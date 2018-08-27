<?php
/**
 * circular notice select sort for view element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$url = NetCommonsUrl::actionUrlAsArray(array_merge(array(
	'plugin' => 'circular_notices',
	'controller' => 'circular_notices',
	'action' => 'index',
	'block_id' => Current::read('Block.id'),
	'frame_id' => Current::read('Frame.id'),
), $this->Paginator->params['named']));
?>

<div class="btn-group">
	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $sortOptions[$currentSort . '.' . $currentDirection]['label']; ?>
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<?php foreach ($sortOptions as $key => $sort) : ?>
			<li>
				<?php echo $this->Paginator->link($sort['label'], array('sort' => $sort['sort'], 'direction' => $sort['direction']), array('url' => $url)); ?>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
