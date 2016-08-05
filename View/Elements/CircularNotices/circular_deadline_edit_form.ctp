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
	$circularNoticeContent['use_reply_deadline'] = ($circularNoticeContent['use_reply_deadline']) ? 1 : 0;
?>

<div class="form-group" ng-controller="CircularNoticeDeadline" ng-init="initialize(<?php echo $circularNoticeContent['use_reply_deadline']; ?>)">
	<div>
		<?php echo $this->NetCommonsForm->label(
			'CircularNoticeContent.use_reply_deadline',
			__d('circular_notices', 'Reply Deadline') . $this->element('NetCommons.required')
		); ?>
	</div>
	<?php
		$options = array(
			'0' => __d('circular_notices', 'No Deadline'),
			'1' => __d('circular_notices', 'Set Deadline'),
		);
		echo $this->NetCommonsForm->radio('CircularNoticeContent.use_reply_deadline', $options, array(
			'value' => $circularNoticeContent['use_reply_deadline'],
			'ng-click' => 'switchDeadline($event)',
			'outer' => false,
		));
	?>
	<div  ng-show="deadline==1" class="col-xs-12">
		<div class="input-group inline-block">
			<div class="input-group">
				<?php echo $this->NetCommonsForm->input('CircularNoticeContent.reply_deadline', array(
					'type' => 'datetime',
					'ng-model' => 'circularNoticeContent.reply_deadline',
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
