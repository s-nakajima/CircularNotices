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
	echo $this->Html->script(
		array(
			'/circular_notices/js/circular_notices.js',
		),
		array(
			'plugin' => false,
			'once' => false,
			'inline' => false
		)
	);
?>
<?php
	echo $this->Html->css(
		array(
			'/circular_notices/css/circular_notices.css'
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

	<h1>
		<?php echo h(__d('circular_notices', 'Plugin Name')); ?>
	</h1>

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

				<?php echo $this->element('CircularNotices/subject_edit_form'); ?>

				<?php echo $this->element('CircularNotices/content_edit_form'); ?>

				<?php echo $this->element('CircularNotices/reply_type_edit_form'); ?>

				<?php echo $this->element('CircularNotices/target_edit_form'); ?>

				<?php echo $this->element('CircularNotices/circular_period_edit_form'); ?>

				<?php echo $this->element('CircularNotices/circular_deadline_edit_form'); ?>

			</div>

			<div class="panel-footer text-center">
				<?php echo $this->Button->cancelAndSaveAndSaveTemp(); ?>
			</div>

		<?php echo $this->Form->end(); ?>

		<?php if ($this->request->params['action'] === 'edit') : ?>
			<div class="panel-footer text-right">
				<?php echo $this->element('CircularNotices/delete_form'); ?>
			</div>
		<?php endif; ?>

	</div>

</div>
