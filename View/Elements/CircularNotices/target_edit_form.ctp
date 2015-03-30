<?php
/**
 * announcements edit form element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="form-group">
	<?php echo $this->Form->label('CircularNoticeTargetUser.userId',
			__d('circular_notices', 'Circular Target') . $this->element('NetCommons.required')
	); ?>
	<br />
	<?php echo $this->Form->input('CircularNoticeContent.is_room_targeted_flag',
				array(
					'class' => 'circular-notice-checkbox',
					'div' => false,
					'type' => 'select',
					'label' => false,
					'multiple' => 'checkbox',
					'options' => array(
						$rolesRoomId => __d('circular_notices', 'All Members Belings to this Room'),
					),
				)); ?>
	<?php echo $this->Form->input('CircularNoticeContent.target_groups',
				array(
					'class' => 'circular-notice-checkbox',
					'div' => false,
					'type' => 'select',
					'label' => false,
					'multiple' => 'checkbox',
					'options' => $groups,
				)); ?>
			<br />
</div>
