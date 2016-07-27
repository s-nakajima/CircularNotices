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
		<?php echo $this->NetCommonsForm->label(
			'CircularNoticeTargetUser.period',
			__d('circular_notices', 'Period') . $this->element('NetCommons.required')
		); ?>
	</div>
	<div>
		<div class="form-inline">
			<div class="input-group">
				<?php echo $this->NetCommonsForm->input('CircularNoticeContent.publish_start', array(
					'type' => 'datetime',
					'ng-model' => 'circularNoticeContent.publish_start',
					'label' => false,
					'error' => false,
					'div' => false,
					'class' => 'form-control',
					'placeholder' => 'yyyy-mm-dd hh:mm',
				)); ?>
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-minus"></span>
				</span>
				<?php echo $this->NetCommonsForm->input('CircularNoticeContent.publish_end', array(
					'type' => 'datetime',
					'ng-model' => 'circularNoticeContent.publish_end',
					'label' => false,
					'error' => false,
					'div' => false,
					'class' => 'form-control',
					'placeholder' => 'yyyy-mm-dd hh:mm',
				)); ?>
			</div>
			<?php echo $this->NetCommonsForm->error('CircularNoticeContent.publish_start');?>
			<?php if ($this->NetCommonsForm->error('CircularNoticeContent.publish_start')
					!== $this->NetCommonsForm->error('CircularNoticeContent.publish_end')):?>
				<?php echo $this->NetCommonsForm->error('CircularNoticeContent.publish_end');?>
			<?php endif; ?>
		</div>
	</div>
</div>