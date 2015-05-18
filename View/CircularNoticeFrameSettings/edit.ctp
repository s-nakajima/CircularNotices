<?php
/**
 * block index template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="modal-body">
	<?php echo $this->element('NetCommons.setting_tabs', array(
			'tabs' => array(
				'frame_settings' => array('url' => '/circular_notices/circular_notice_frame_settings/edit/' . $frameId),
				__d('circular_notices', 'Privilege Setting') => array('url' => '/circular_notices/circular_notice_settings/edit/' . $blockId),
			),
			'active' => 'frame_settings'
		)); ?>

	<div class="tab-content">
		<?php echo $this->Form->create('CircularNoticeFrameSetting', array(
				'name' => 'form',
				'novalidate' => true,
			)); ?>

		<?php echo $this->element('Blocks.edit_form', array(
				'controller' => 'Blocks',
				'action' => 'edit' . '/' . $frameId,
				'callback' => 'CircularNotices.CircularNoticeFrameSettings/edit_form',
				'cancel' => $this->Html->url(isset($current['page']) ? '/' . $current['page']['permalink'] : null)
			)); ?>
	</div>
</div>




