<div class="circularNotices view">
<h2><?php echo __('Circular Notice'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($circularNotice['CircularNotice']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Block'); ?></dt>
		<dd>
			<?php echo $this->Html->link($circularNotice['Block']['name'], array('controller' => 'blocks', 'action' => 'view', $circularNotice['Block']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Key'); ?></dt>
		<dd>
			<?php echo h($circularNotice['CircularNotice']['key']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($circularNotice['CircularNotice']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Posts Authority'); ?></dt>
		<dd>
			<?php echo h($circularNotice['CircularNotice']['posts_authority']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mail Notice Flag'); ?></dt>
		<dd>
			<?php echo h($circularNotice['CircularNotice']['mail_notice_flag']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mail Subject'); ?></dt>
		<dd>
			<?php echo h($circularNotice['CircularNotice']['mail_subject']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mail Body'); ?></dt>
		<dd>
			<?php echo h($circularNotice['CircularNotice']['mail_body']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Auto Translated'); ?></dt>
		<dd>
			<?php echo h($circularNotice['CircularNotice']['is_auto_translated']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Translation Engine'); ?></dt>
		<dd>
			<?php echo h($circularNotice['CircularNotice']['translation_engine']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Trackable Creator'); ?></dt>
		<dd>
			<?php echo $this->Html->link($circularNotice['TrackableCreator']['id'], array('controller' => 'users', 'action' => 'view', $circularNotice['TrackableCreator']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($circularNotice['CircularNotice']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Trackable Updater'); ?></dt>
		<dd>
			<?php echo $this->Html->link($circularNotice['TrackableUpdater']['id'], array('controller' => 'users', 'action' => 'view', $circularNotice['TrackableUpdater']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($circularNotice['CircularNotice']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Circular Notice'), array('action' => 'edit', $circularNotice['CircularNotice']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Circular Notice'), array('action' => 'delete', $circularNotice['CircularNotice']['id']), null, __('Are you sure you want to delete # %s?', $circularNotice['CircularNotice']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Circular Notices'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Circular Notice'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Blocks'), array('controller' => 'blocks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Block'), array('controller' => 'blocks', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trackable Creator'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
