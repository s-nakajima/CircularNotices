<?php
/**
 * メール設定 template
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>

<div class="block-setting-body">

	<div class="tab-content">
		<?php echo $this->BlockTabs->main(BlockTabsHelper::MAIN_TAB_MAIL_SETTING); ?>

		<?php echo $this->element('Mails.edit_form', array(
			'mailBodyPopoverMessage' => __d('circular_notices', 'MailSetting.mail_fixed_phrase_body.popover'),
			'MailSetting.mail_fixed_phrase_subject' => __d('circular_notices', 'mail_fixed_phrase_subject'),
			'MailSetting.mail_fixed_phrase_body' => __d('circular_notices', 'mail_fixed_phrase_body'),
			'cancelUrl' => NetCommonsUrl::backToIndexUrl('default_setting_action'),
			'useNoticeAuthority' => 0,
			'useReplayTo' => 0,
		)); ?>
	</div>
</div>
