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

<div class="modal-body">
	<?php echo $this->element('NetCommons.setting_tabs', $settingTabs); ?>
	<div class="tab-content">
		<?php echo $this->element('Blocks.edit_form', array(
			'controller' => 'CircularNoticeBlockRolePermissions',
			'action' => 'edit' . '/' . $frameId . '/' . $blockId,
			'callback' => 'CircularNotices.CircularNoticeBlockRolePermissions/edit_form',
			'cancelUrl' => $this->Html->url(isset($current['page']) ? '/' . $current['page']['permalink'] : null),
			'options' => array('ng-controller' => 'CircularNotices'),
		)); ?>
	</div>
</div>
