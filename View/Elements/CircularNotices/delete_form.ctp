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

<?php echo $this->Form->create('CircularNotice', array('type' => 'delete', 'action' => 'delete/' . $frameId . '/' . $circularNoticeContent['key'])); ?>
	<?php echo $this->Form->button('<span class="glyphicon glyphicon-trash"> </span>', array(
		'name' => 'delete',
		'class' => 'btn btn-danger',
		'onclick' => 'return confirm(\'' . sprintf(__d('net_commons', 'Deleting the %s. Are you sure to proceed?'), __d('circular_notices', 'Circular Notice')) . '\')'
	)); ?>
<?php echo $this->Form->end();
