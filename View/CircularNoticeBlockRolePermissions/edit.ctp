<?php
/**
 * circular notice block role permissions edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="block-setting-body">
	<?php echo $this->BlockTabs->main(BlockTabsComponent::MAIN_TAB_PERMISSION); ?>
	<div class="tab-content">
		<?php echo $this->element('Blocks.edit_form', array(
			'model' => 'CircularNoticeFrameSetting',
			'callback' => 'CircularNotices.CircularNoticeBlockRolePermissions/edit_form',
			'cancelUrl' => NetCommonsUrl::backToPageUrl(),
		)); ?>
	</div>
</div>