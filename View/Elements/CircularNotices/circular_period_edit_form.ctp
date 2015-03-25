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
	<?php echo $this->Form->label('CircularNoticeTargetUser.period',
			__d('circular_notices', 'Period') . $this->element('NetCommons.required')
	); ?>
	<div class="form-inline">
		<?php
			echo $this->Form->input('CircularNoticeContent.period_start_date',
			array(
				'class' => 'form-control circular-notice-date',
				'div' => false,
				'type' => 'text',
				'label' => false,
				'value' => '',
				'style' => 'width: 100px;',
			));
		?>

		<?php echo $this->Form->select('CircularNoticeContent.period_start_hour',
				array(
					0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23,
				),
				array(
					'class' => 'form-control',
					'div' => false,
					'empty' => null,
				)); ?>

		<?php echo __d('circular_notices', 'Hour'); ?>

		<?php echo $this->Form->select('CircularNoticeContent.period_start_minute',
				array(
					0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55,
				),
				array(
					'class' => 'form-control',
					'div' => false,
					'empty' => null,
				)); ?>

		<?php echo __d('circular_notices', 'Minute'); ?>

		<?php echo __d('circular_notices', 'Till'); ?>

		<?php
			echo $this->Form->input('CircularNoticeContent.period_end_date',
			array(
				'class' => 'form-control',
				'div' => false,
				'type' => 'text',
				'label' => false,
				'value' => '',
				'style' => 'width: 100px;',
			)); ?>

		<?php echo $this->Form->select('CircularNoticeContent.period_end_hour',
				array(
					0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23,
				),
				array(
					'class' => 'form-control',
					'div' => false,
					'empty' => null,
				)); ?>

		<?php echo __d('circular_notices', 'Hour'); ?>

		<?php echo $this->Form->select('CircularNoticeContent.period_end_minute',
				array(
					0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55,
				),
				array(
					'class' => 'form-control',
					'div' => false,
					'empty' => null,
				)); ?>

		<?php echo __d('circular_notices', 'Minute'); ?>
	</div>
</div>