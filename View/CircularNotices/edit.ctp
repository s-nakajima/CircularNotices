<?php
/**
 * RssReaders edit form element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Html->script('/net_commons/base/js/workflow.js', false); ?>
<?php echo $this->Html->script('/net_commons/base/js/wysiwyg.js', false); ?>
<?php echo $this->Html->css('/circularNotices/css/circular_notices.css'); ?>
<?php echo $this->Html->script('/circularNotices/js/circular_notices.js'); ?>

<div id="nc-circular-notices-<?php echo (int)$frameId; ?>"
	 ng-controller="CircularNotices"
	 ng-init="initCircularNoticeEdit(<?php echo h(json_encode($this->viewVars['circularNoticeContent'])); ?>)">

	<div class="modal-header">
		<?php echo __d('circular_notices', 'Plugin Name'); ?>
	</div>

	<div class="panel panel-default">
		<div class="panel-body">
			<?php echo $this->Form->create('CircularNoticeContent', array(
					'name' => 'form',
					'novalidate' => true,
				)); ?>

				<?php echo $this->Form->hidden('Frame.id', array(
					'value' => $frameId
				)); ?>

				<?php echo $this->Form->hidden('Block.id', array(
					'value' => $blockId,
				)); ?>

				<?php /* タイトル */ ?>
				<?php echo $this->element('CircularNotices/subject_edit_form'); ?>

				<?php /* 回覧内容 */ ?>
				<?php echo $this->element('CircularNotices/content_edit_form'); ?>

				<?php /* 回答方式 */ ?>
				<?php echo $this->element('CircularNotices/reply_type_edit_form'); ?>

				<?php /* 回覧先 */ ?>
				<?php echo $this->element('CircularNotices/target_edit_form'); ?>

				<?php /* 回覧期間 */ ?>
				<?php echo $this->element('CircularNotices/circular_period_edit_form'); ?>

				<?php /* 回答期限 */ ?>
				<?php echo $this->element('CircularNotices/circular_deadline_edit_form'); ?>

				<hr>

				<?php /* コメント */ ?>
				<?php echo $this->element('Comments.form'); ?>
					<div class="panel-footer text-center">
						<?php echo $this->element('NetCommons.workflow_buttons'); ?>
					</div>

			<?php echo $this->Form->end(); ?>

		</div>
	</div>
</div>
