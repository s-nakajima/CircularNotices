<?php
/**
 * circular notice frame settings edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="block-setting-body">
	<?php echo $this->BlockTabs->main(BlockTabsComponent::MAIN_TAB_MAIL_SETTING); ?>
	<div class="tab-content">
		<?php echo $this->element('Mails.edit_form', array(
			'model' => 'MailSetting',
			'callback' => 'CircularNotices.CircularNoticeMailSettings/edit_form',
			'cancelUrl' => NetCommonsUrl::backToPageUrl(),
		)); ?>
	</div>
</div>