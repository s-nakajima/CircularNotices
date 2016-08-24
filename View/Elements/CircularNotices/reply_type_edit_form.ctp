<?php
/**
 * circular notice edit reply element
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
		<?php echo $this->NetCommonsForm->label(
			'CircularNoticeContent.reply_type',
			__d('circular_notices', 'Reply Type') . $this->element('NetCommons.required')
		); ?>
	</div>
	<div>
		<?php echo $this->NetCommonsForm->select('CircularNoticeContent.reply_type',
			array(
				CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT => __d('net_commons', 'Free style'),
				CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION => __d('net_commons', 'Single choice'),
				CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION => __d('net_commons', 'Multiple choice'),
			),
			array(
				'class' => 'form-control',
				'div' => false,
				'empty' => null,
				'ng-model' => 'circularNoticeContent.reply_type',
		)); ?>
	</div>
</div>

<div class="form-group" ng-show="circularNoticeContent.reply_type!=<?php echo h(CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT); ?>">
	<?php echo $this->element('CircularNotices/choice_edit_form'); ?>
	<div class="has-error">
		<?php echo $this->NetCommonsForm->error('CircularNoticeContent.reply_type', null, array('class' => 'help-block')); ?>
	</div>
</div>

