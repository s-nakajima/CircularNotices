<?php
/**
 * circular notice block role permissions edit form element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->NetCommonsForm->hidden('Block.id', array(
		'value' => Current::read('Block.id'),
	)); ?>

<?php echo $this->NetCommonsForm->hidden('CircularNoticeSetting.id', array(
		'value' => isset($circularNoticeSetting['id']) ? (int)$circularNoticeSetting['id'] : null,
	)); ?>

<?php echo $this->NetCommonsForm->hidden('CircularNoticeSetting.key', array(
		'value' => isset($circularNoticeSetting['key']) ? $circularNoticeSetting['key'] : null,
	)); ?>

<?php echo $this->element('Blocks.block_creatable_setting', array(
	'settingPermissions' => array(
		'content_creatable' => __d('circular_notices', 'Content creatable roles'),
	),
));
