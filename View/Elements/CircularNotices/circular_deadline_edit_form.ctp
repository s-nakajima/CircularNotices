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
	<?php echo $this->Form->label('CircularNoticeTargetUser.reply_deadline_set_flag',
			__d('circular_notices', 'Reply Deadline') . $this->element('NetCommons.required')
	); ?>
	<div class="form-inline">
		<?php
			echo $this->Form->input('CircularNoticeContent.reply_deadline_set_flag',
				array(
					'class' => 'form-control',
					'type' => 'radio',
					'div' => true,
					'legend' => false,
					'ng-model' => 'reply_deadline_set_flag',
					'options' => array(
						'0' => __d('circular_notices', 'No Deadline'),
						'1' => __d('circular_notices', 'Set Deadline'),
					),
				));
		?>
		<?php
			echo $this->Form->input('CircularNoticeContent.deadline_date',
			array(
				'class' => 'form-control circular-notice-date',
				'div' => false,
				'type' => 'text',
				'label' => false,
				'value' => '',
				'ng-readonly' => 'reply_deadline_set_flag != 1',
				'style' => 'width: 100px;',
			));
		?>
		<?php echo $this->Form->select('CircularNoticeContent.deadline_hour',
				array(
					0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23,
				),
				array(
					'class' => 'form-control',
					'div' => false,
					'empty' => null,
					'ng-disabled' => 'reply_deadline_set_flag != 1',
				)); ?>

		<?php echo __d('circular_notices', 'Hour'); ?>

		<?php echo $this->Form->select('CircularNoticeContent.deadline_minute',
				array(
					0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55,
				),
				array(
					'class' => 'form-control',
					'div' => false,
					'empty' => null,
					'ng-disabled' => 'reply_deadline_set_flag != 1',
				)); ?>

		<?php echo __d('circular_notices', 'Minute'); ?>
	</div>
</div>