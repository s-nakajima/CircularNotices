<?php
/**
 * circular notice edit period element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="form-group" style="margin-bottom: 10px;">
	<div>
		<?php echo $this->Form->label(
			'CircularNoticeTargetUser.period',
			__d('circular_notices', 'Period') . $this->element('NetCommons.required')
		); ?>
	</div>
	<div>
		<div class="input-group inline-block">
			<div class="input-group">
				<?php echo $this->NetCommonsForm->input('CircularNoticeContent.publish_start', array(
					'type' => 'text',
					'ng-model' => 'circularNoticeContent.publishStart',
					'datetimepicker',
					'label' => false,
					'class' => 'form-control',
					'placeholder' => 'yyyy-mm-dd hh:mm',
				)); ?>
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-minus"></span>
				</span>
				<?php echo $this->NetCommonsForm->input('CircularNoticeContent.publish_end', array(
					'type' => 'text',
					'ng-model' => 'circularNoticeContent.publishEnd',
					'datetimepicker',
					'label' => false,
					'class' => 'form-control',
					'placeholder' => 'yyyy-mm-dd hh:mm',
				)); ?>
			</div>
		</div>
	</div>
</div>