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

<?php echo $this->NetCommonsForm->hidden('id'); ?>
<?php echo $this->NetCommonsForm->hidden('Frame.id'); ?>
<?php echo $this->NetCommonsForm->hidden('Block.id'); ?>

<?php echo $this->NetCommonsForm->hidden('CircularNoticeFrameSetting.id', array(
	'value' => isset($circularNoticeFrameSetting['id']) ? (int)$circularNoticeFrameSetting['id'] : null,
	)); ?>

<?php echo $this->NetCommonsForm->hidden('CircularNoticeFrameSetting.frame_key', array(
	'value' => Current::read('Frame.key'),
	)); ?>

<div class="form-group">
	<?php echo $this->NetCommonsForm->label(__d('circular_notices', 'Show contents per page')); ?>
	<?php echo $this->NetCommonsForm->select('CircularNoticeFrameSetting.display_number',
			CircularNoticeFrameSetting::getDisplayNumberOptions(),
			array(
				'type' => 'select',
				'class' => 'form-control',
				'value' => $circularNoticeFrameSetting['displayNumber'],
				'empty' => false,
			)
		); ?>
</div>
