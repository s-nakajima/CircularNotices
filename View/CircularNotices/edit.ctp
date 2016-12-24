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

<div id="nc-circular-notices-<?php echo Current::read('Frame.id'); ?>"
	 ng-controller="CircularNoticeEdit"
	 ng-init="initialize(<?php echo h(json_encode($circularNoticeContent)); ?>)">
	<article>

		<div class="panel panel-default">

			<?php echo $this->NetCommonsForm->create('CircularNoticeContent', array(
				'name' => 'form',
				'novalidate' => true,
			)); ?>

				<div class="panel-body">

					<?php echo $this->NetCommonsForm->hidden('Frame.id', array(
						'value' => Current::read('Frame.id')
					)); ?>

					<?php echo $this->NetCommonsForm->hidden('Block.id', array(
						'value' => Current::read('Block.id'),
					)); ?>

					<?php echo $this->NetCommonsForm->hidden('CircularNoticeContent.id', array(
						'value' => isset($circularNoticeContent['id']) ? $circularNoticeContent['id'] : null,
					)); ?>

					<?php echo $this->NetCommonsForm->hidden('CircularNoticeContent.language_id', array(
						'value' => isset($circularNoticeContent['language_id']) ? $circularNoticeContent['language_id'] : Current::read('Language.id'),
					)); ?>

					<?php
						$circularNoticeSettingKey = $circularNoticeSetting['CircularNoticeSetting']['key'];
						if (isset($circularNoticeContent['circular_notice_setting_key'])
								&& !empty($circularNoticeContent['circular_notice_setting_key'])) {
							$circularNoticeSettingKey = $circularNoticeContent['circular_notice_setting_key'];
						}
						echo $this->NetCommonsForm->hidden('CircularNoticeContent.circular_notice_setting_key', array(
							'value' => $circularNoticeSettingKey,
						));
					?>

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

			<?php echo $this->NetCommonsForm->end(); ?>

			<?php if ($this->request->params['action'] === 'edit') : ?>
				<div class="panel-footer text-right">
					<?php echo $this->element('CircularNotices/delete_form'); ?>
				</div>
			<?php endif; ?>
		</div>
	</article>
</div>
