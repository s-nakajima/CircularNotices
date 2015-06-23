<?php
/**
 * circular notice edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
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
			'once' => true,
			'inline' => false
		)
	);
?>
<?php echo $this->element('NetCommons.datetimepicker'); ?>
<?php
	$this->Html->css(
		array(
			'/circularNotices/css/circular_notices.css'
		),
		array(
			'plugin' => false,
			'once' => true,
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
					'value' => isset($circularNoticeContent['circular_notice_setting_key']) ? $circularNoticeContent['circular_notice_setting_key'] : $circularNoticeSetting['CircularNoticeSetting']['key'],
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
				<?php if ($this->request->params['action'] === 'edit') { ?>
					<?php if (
						$circularNoticeContent['currentStatus'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_IN_DRAFT ||
						$circularNoticeContent['currentStatus'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_RESERVED
					) { ?>
						<?php echo $this->element('NetCommons.workflow_buttons'); ?>
					<?php } else { ?>
						<a href="<?php echo $this->Html->url('/') ?>" class="btn btn-default btn-workflow">
							<span class="glyphicon glyphicon-remove"></span>
							<?php echo __d('net_commons', 'Cancel') ?>
						</a>
					<?php } ?>
				<?php } else { ?>
					<?php echo $this->element('NetCommons.workflow_buttons'); ?>
				<?php } ?>
			</div>

		<?php echo $this->Form->end(); ?>

		<?php if ($this->request->params['action'] === 'edit') : ?>
			<div class="panel-footer text-right">
				<?php echo $this->element('CircularNotices/delete_form'); ?>
			</div>
		<?php endif; ?>

	</div>
</div>
