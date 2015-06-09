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

<?php
	$this->Html->script(
		array(
			'/net_commons/js/workflow.js',
			'/net_commons/js/wysiwyg.js',
			'/circularNotices/js/circular_notices.js'
		),
		array(
			'plugin' => false,
			'inline' => false
		)
	);
?>
<?php
	$this->Html->css(
		array(
			'/circularNotices/css/circular_notices.css'
		),
		array(
			'plugin' => false,
			'inline' => false
		)
	);
?>

<div id="nc-circular-notices-<?php echo (int)$frameId; ?>"
	 ng-controller="CircularNoticeEdit"
	 ng-init="initialize(<?php echo h(json_encode($this->viewVars['circularNoticeContent'])); ?>)">

	<div class="modal-header">
		<?php echo h(__d('circular_notices', 'Plugin Name')); ?>
	</div>

	<div class="panel panel-default">

		<?php echo $this->Form->create('CircularNoticeContent', array(
				'name' => 'form',
				'novalidate' => true,
			)); ?>

			<div class="panel-body">

				<?php echo $this->Form->hidden('Frame.id', array(
					'value' => $frameId
				)); ?>

				<?php echo $this->Form->hidden('Block.id', array(
					'value' => $blockId,
				)); ?>

				<?php echo $this->Form->hidden('CircularNoticeContent.id', array(
					'value' => isset($circularNoticeContent['id']) ? $circularNoticeContent['id'] : null,
				)); ?>

				<?php echo $this->Form->hidden('CircularNoticeContent.circular_notice_setting_key', array(
					'value' => isset($circularNoticeContent['circular_notice_setting_key']) ? $circularNoticeContent['circular_notice_setting_key'] : $circularNoticeSetting['key'],
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

			</div>

			<div class="panel-footer text-center">
				<?php echo $this->element('NetCommons.workflow_buttons'); ?>
			</div>

		<?php echo $this->Form->end(); ?>

		<?php if ($this->request->params['action'] === 'edit') : ?>
			<div class="panel-footer text-right">
				<?php echo $this->element('CircularNotices/delete_form'); ?>
			</div>
		<?php endif; ?>

	</div>
</div>
