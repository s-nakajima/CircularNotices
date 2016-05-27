<?php
/**
 * circular notice delete form element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->NetCommonsForm->create('CircularNotice', array(
	'type' => 'delete',
	'url' => $this->NetCommonsHtml->url(array('action' => 'delete', 'key' => $circularNoticeContent['key']))
)); ?>
<?php echo $this->NetCommonsForm->hidden('Frame.id'); ?>
<?php echo $this->NetCommonsForm->hidden('Block.id'); ?>
<?php echo $this->NetCommonsForm->hidden('Block.key'); ?>

<?php echo $this->NetCommonsForm->hidden('CircularNoticeContent.id'); ?>
<?php echo $this->NetCommonsForm->hidden('CircularNoticeContent.key'); ?>
<?php echo $this->NetCommonsForm->hidden('CircularNoticeContent.language_id'); ?>

<?php echo $this->Button->delete('',
	sprintf(__d('net_commons', 'Deleting the %s. Are you sure to proceed?'), __d('circular_notices', '回覧'))
); ?>
<?php echo $this->NetCommonsForm->end();
