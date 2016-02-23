<?php
/**
 * circular notice edit mail element
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>

<div class="form-group">
	<div>
		<?php echo $this->Form->label(
			'CircularNoticeContent.mail_notice_flag',
			__d('circular_notices', 'メール通知') . $this->element('NetCommons.required')
		); ?>
	</div>
	<div class="col-xs-offset-1 col-xs-11">
		<?php
			$options = array(
				'1' => __d('circular_notices', 'メールで通知する'),
				'0' => __d('circular_notices', 'メールで通知しない'),
			);
			echo $this->Form->radio('CircularNoticeContent.mail_notice_flag', $options, array(
				'value' => (isset($circularNoticeContent['mail_notice_flag']) ? $circularNoticeContent['mailNoticeFlag'] : 1),
				'legend' => false,
				'separator' => '<br />',
			));
		?>
	</div>
</div>
