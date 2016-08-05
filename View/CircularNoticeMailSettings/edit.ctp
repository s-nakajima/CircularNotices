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

		<?php /** @see MailFormHelper::editFrom() */ ?>
		<?php echo $this->MailForm->editFrom(
			array(
				array(
					'mailBodyPopoverMessage' => __d('circular_notices', 'MailSetting.mail_fixed_phrase_body.popover'),
					'useNoticeAuthority' => 0,
				),
			),
			NetCommonsUrl::backToPageUrl(true),
			0, // 問合せ先メールアドレス 非表示
			0, // メール通知機能を使う ヘルプメッセージ 非表示
			0 // 承認メール通知機能を使う 非表示
		); ?>
	</div>
</div>
