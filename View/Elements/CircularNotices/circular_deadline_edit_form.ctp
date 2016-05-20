<?php
/**
 * circular notice edit deadline element
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
			'CircularNoticeContent.reply_deadline_set_flag',
			__d('circular_notices', 'Reply Deadline') . $this->element('NetCommons.required')
		); ?>
	</div>
	<div class="col-xs-offset-1 col-xs-11">
		<?php
			$options = array(
				'0' => __d('circular_notices', 'No Deadline'),
				'1' => __d('circular_notices', 'Set Deadline'),
			);
			echo $this->Form->radio('CircularNoticeContent.reply_deadline_set_flag', $options, array(
				'value' => (isset($circularNoticeContent['replyDeadlineSetFlag']) ? $circularNoticeContent['replyDeadlineSetFlag'] : 0),
				'legend' => false,
				'separator' => '<br />',
			));
		?>
	</div>
	<div class="col-xs-offset-1 col-xs-11">
		<div class="input-group inline-block">
			<div class="input-group">
				<?php echo $this->Form->input('CircularNoticeContent.reply_deadline', array(
					'type' => 'text',
					'ng-model' => 'circularNoticeContent.replyDeadline',
					'datetimepicker',
					'label' => false,
					'error' => false,
					'class' => 'form-control',
					'placeholder' => 'yyyy-mm-dd hh:mm',
				)); ?>
			</div>
			<?php echo $this->NetCommonsForm->error('CircularNoticeContent.reply_deadline') ;?>
		</div>
	</div>
</div>
