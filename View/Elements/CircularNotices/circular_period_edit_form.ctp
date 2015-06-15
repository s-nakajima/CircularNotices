<?php
/**
 * announcements edit form element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="form-group">
	<div>
		<?php echo $this->Form->label(
			'CircularNoticeTargetUser.period',
			__d('circular_notices', 'Period') . $this->element('NetCommons.required')
		); ?>
	</div>
	<div>
		<div class="input-group inline-block" style="margin-left: 20px;">
			<div class="input-group">
				<?php echo $this->Form->input('CircularNoticeContent.opened_period_from', array(
					'type' => 'text',
					'ng-model' => 'circularNoticeContent.openedPeriodFrom',
					'datetimepicker',
					'label' => false,
					'class' => 'form-control',
					'placeholder' => 'yyyy-mm-dd hh:mm',
				)); ?>
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-minus"></span>
				</span>
				<?php echo $this->Form->input('CircularNoticeContent.opened_period_to', array(
					'type' => 'text',
					'ng-model' => 'circularNoticeContent.openedPeriodTo',
					'datetimepicker',
					'label' => false,
					'class' => 'form-control',
					'placeholder' => 'yyyy-mm-dd hh:mm',
				)); ?>
			</div>
		</div>
	</div>
	<div>
		<?php echo $this->element(
			'NetCommons.errors', [
				'errors' => $this->validationErrors,
				'model' => 'CircularNoticeContent',
				'field' => 'opened_period_from',
		]) ?>
		<?php echo $this->element(
			'NetCommons.errors', [
				'errors' => $this->validationErrors,
				'model' => 'CircularNoticeContent',
				'field' => 'opened_period_to',
		]) ?>
	</div>
</div>