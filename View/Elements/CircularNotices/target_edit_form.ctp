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

<div class="row form-group">
	<div class="col-xs-12">
		<?php echo $this->Form->label('CircularNoticeTargetUser.userId',
				__d('circular_notices', 'Circular Target') . $this->element('NetCommons.required')
		); ?>
	</div>
	<div class="col-xs-offset-1 col-xs-11">
		<?php echo $this->Form->input('CircularNoticeContent.is_room_targeted_flag', array(
			'class' => 'circular-notice-checkbox',
			'div' => false,
			'type' => 'select',
			'label' => false,
			'multiple' => 'checkbox',
			'selected' => $circularNoticeContent['isRoomTargetedFlag'],
			'options' => array(
				'1' => __d('circular_notices', 'All Members Belings to this Room'),
			),
		)); ?>
		<?php
			$options = array();
			foreach ($groups as $group) {
				$options[$group['group']['id']] = $group['group']['name'];
			}
			echo $this->Form->input('CircularNoticeContent.target_groups', array(
				'class' => 'circular-notice-checkbox',
				'div' => false,
				'type' => 'select',
				'label' => false,
				'multiple' => 'checkbox',
				'selected' => $circularNoticeContent['targetGroups'],
				'options' => $options,
			));
		?>
	</div>
</div>
