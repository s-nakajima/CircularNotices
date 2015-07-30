<?php
/**
 * circular notice frame settings edit form element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Form->hidden('Frame.id', array(
	'value' => $frameId,
	)); ?>

<?php echo $this->Form->hidden('CircularNoticeFrameSetting.id', array(
	'value' => isset($circularNoticeFrameSetting['id']) ? (int)$circularNoticeFrameSetting['id'] : null,
	)); ?>

<?php echo $this->Form->hidden('CircularNoticeFrameSetting.frame_key', array(
	'value' => $frameKey,
	)); ?>

<div class="form-group">
	<?php echo $this->Form->label(__d('circular_notices', 'Show contents per page')); ?>
	<?php echo $this->Form->select('CircularNoticeFrameSetting.display_number',
			CircularNoticeFrameSetting::getDisplayNumberOptions(),
			array(
				'type' => 'select',
				'class' => 'form-control',
				'value' => $circularNoticeFrameSetting['displayNumber'],
				'empty' => false,
			)
		); ?>
</div>
