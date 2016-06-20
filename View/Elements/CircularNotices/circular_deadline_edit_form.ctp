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
<?php
	$circularNoticeContent['replyDeadlineSetFlag'] = ($circularNoticeContent['replyDeadlineSetFlag']) ? 1 : 0;
?>

<div class="form-group" ng-controller="CircularNoticeDeadline" ng-init="initialize(<?php echo $circularNoticeContent['replyDeadlineSetFlag']; ?>)">
	<div>
		<?php echo $this->NetCommonsForm->label(
			'CircularNoticeContent.reply_deadline_set_flag',
			__d('circular_notices', 'Reply Deadline') . $this->element('NetCommons.required')
		); ?>
	</div>
	<?php
		$options = array(
			'0' => __d('circular_notices', 'No Deadline'),
			'1' => __d('circular_notices', 'Set Deadline'),
		);
		echo $this->NetCommonsForm->radio('CircularNoticeContent.reply_deadline_set_flag', $options, array(
			'value' => $circularNoticeContent['replyDeadlineSetFlag'],
			'ng-click' => 'switchDeadline($event)',
			'outer' => false,
		));
	?>
	<div  ng-show="deadline==1" class="col-xs-12">
		<div class="input-group inline-block">
			<div class="input-group">
				<?php echo $this->NetCommonsForm->input('CircularNoticeContent.reply_deadline', array(
					'type' => 'datetime',
					'ng-model' => 'circularNoticeContent.replyDeadline',
					'label' => false,
					'error' => false,
					'class' => 'form-control',
					'placeholder' => 'yyyy-mm-dd hh:mm',
					'div' => false,
				)); ?>
			</div>
			<?php echo $this->NetCommonsForm->error('CircularNoticeContent.reply_deadline');?>
		</div>
	</div>
</div>
