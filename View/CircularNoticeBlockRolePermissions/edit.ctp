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

<!--<div class="modal-body">-->
<!--	<div class="tab-content">-->
<!--		--><?php //echo $this->element('Blocks.edit_form', array(
//			'controller' => 'CircularNoticeBlockRolePermissions',
////			'action' => 'edit' . '/' . $frameId . '/' . $blockId,
//			'action' => 'edit' . '/' . Current::read('Frame.id') . '/' . Current::read('Block.id'),
//			'callback' => 'CircularNotices.CircularNoticeBlockRolePermissions/edit_form',
//			'cancelUrl' => NetCommonsUrl::backToIndexUrl('default_setting_action'),
////			'options' => array('ng-controller' => 'CircularNotices'),
//		)); ?>
<!--	</div>-->
<!--</div>-->
<div class="block-setting-body">
<!--	--><?php //echo $this->BlockTabs->main(BlockTabsComponent::MAIN_TAB_BLOCK_INDEX); ?>
		<?php echo $this->BlockTabs->main(BlockTabsComponent::MAIN_TAB_PERMISSION); ?>

	<div class="tab-content">
<!--		--><?php //echo $this->BlockTabs->block(BlockTabsComponent::BLOCK_TAB_PERMISSION); ?>

		<?php echo $this->element('Blocks.edit_form', array(
			'model' => 'CircularNoticeFrameSetting',
			'callback' => 'CircularNotices.CircularNoticeBlockRolePermissions/edit_form',
			'cancelUrl' => NetCommonsUrl::backToPageUrl(),
		)); ?>
	</div>
</div>