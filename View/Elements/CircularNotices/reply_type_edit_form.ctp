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
	<?php echo $this->Form->label('CircularNoticeContent.replyType',
			__d('circular_notices', 'Reply Type') . $this->element('NetCommons.required')
	); ?>

	<?php echo $this->Form->select('CircularNoticeContent.reply_type',
			array(
				CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT => __d('circular_notices', 'Reply Type Text'),
				CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION => __d('circular_notices', 'Reply Type Selection'),
				CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION => __d('circular_notices', 'Reply Type Multiple Selection'),
			),
			array(
				'class' => 'form-control',
				'div' => false,
				'empty' => null,
				'ng-model' => 'circularNoticeContentReplyType',
//				'ng-change' => 'dispReplySelectForm()',
			)); ?>
</div>

<div class="form-group" ng-show="circularNoticeContentReplyType!=<?php echo CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT ?>">
	<?php echo $this->element('CircularNotices/choice_edit_form'); ?>
</div>
