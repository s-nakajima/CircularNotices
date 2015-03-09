<div class="circularNotices form">
<?php echo $this->Form->create('CircularNotice'); ?>
	<fieldset>
		<legend><?php echo __('Form Circular Notice'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('block_id');
		echo $this->Form->input('key');
		echo $this->Form->input('name');
		echo $this->Form->input('posts_authority');
		echo $this->Form->input('mail_notice_flag');
		echo $this->Form->input('mail_subject');
		echo $this->Form->input('mail_body');
		echo $this->Form->input('is_auto_translated');
		echo $this->Form->input('translation_engine');
		echo $this->Form->input('created_user');
		echo $this->Form->input('modified_user');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('CircularNotice.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('CircularNotice.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Circular Notices'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Blocks'), array('controller' => 'blocks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Block'), array('controller' => 'blocks', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trackable Creator'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
