<div class="circularNotices index">
	<h2><?php echo __('Circular Notices'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('block_id'); ?></th>
			<th><?php echo $this->Paginator->sort('key'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('posts_authority'); ?></th>
			<th><?php echo $this->Paginator->sort('mail_notice_flag'); ?></th>
			<th><?php echo $this->Paginator->sort('mail_subject'); ?></th>
			<th><?php echo $this->Paginator->sort('mail_body'); ?></th>
			<th><?php echo $this->Paginator->sort('is_auto_translated'); ?></th>
			<th><?php echo $this->Paginator->sort('translation_engine'); ?></th>
			<th><?php echo $this->Paginator->sort('created_user'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified_user'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($circularNotices as $circularNotice): ?>
	<tr>
		<td><?php echo h($circularNotice['CircularNotice']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($circularNotice['Block']['name'], array('controller' => 'blocks', 'action' => 'view', $circularNotice['Block']['id'])); ?>
		</td>
		<td><?php echo h($circularNotice['CircularNotice']['key']); ?>&nbsp;</td>
		<td><?php echo h($circularNotice['CircularNotice']['name']); ?>&nbsp;</td>
		<td><?php echo h($circularNotice['CircularNotice']['posts_authority']); ?>&nbsp;</td>
		<td><?php echo h($circularNotice['CircularNotice']['mail_notice_flag']); ?>&nbsp;</td>
		<td><?php echo h($circularNotice['CircularNotice']['mail_subject']); ?>&nbsp;</td>
		<td><?php echo h($circularNotice['CircularNotice']['mail_body']); ?>&nbsp;</td>
		<td><?php echo h($circularNotice['CircularNotice']['is_auto_translated']); ?>&nbsp;</td>
		<td><?php echo h($circularNotice['CircularNotice']['translation_engine']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($circularNotice['TrackableCreator']['id'], array('controller' => 'users', 'action' => 'view', $circularNotice['TrackableCreator']['id'])); ?>
		</td>
		<td><?php echo h($circularNotice['CircularNotice']['created']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($circularNotice['TrackableUpdater']['id'], array('controller' => 'users', 'action' => 'view', $circularNotice['TrackableUpdater']['id'])); ?>
		</td>
		<td><?php echo h($circularNotice['CircularNotice']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $circularNotice['CircularNotice']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $circularNotice['CircularNotice']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $circularNotice['CircularNotice']['id']), null, __('Are you sure you want to delete # %s?', $circularNotice['CircularNotice']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Circular Notice'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Blocks'), array('controller' => 'blocks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Block'), array('controller' => 'blocks', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trackable Creator'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
