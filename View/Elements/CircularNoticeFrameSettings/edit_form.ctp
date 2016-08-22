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

<?php echo $this->NetCommonsForm->hidden('Frame.id'); ?>
<?php echo $this->NetCommonsForm->hidden('CircularNoticeFrameSetting.id'); ?>
<?php echo $this->NetCommonsForm->hidden('CircularNoticeFrameSetting.frame_key'); ?>

<?php echo $this->DisplayNumber->select('CircularNoticeFrameSetting.display_number', array(
	'label' => __d('circular_notices', 'Show contents per page'),
	'unit' => array(
		'single' => __d('circular_notices', '%d items'),
		'multiple' => __d('circular_notices', '%d items')
	),
));
