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
	<?php
		echo $this->Form->input('CircularNoticeContent.target_room',
		array(
			'div' => false,
			'type' => 'checkbox',
			'label' => false,
			'value' => $rolesRoomId,
//				'ng-model' => 'circularNoticeContentReplyType',
//				'ng-change' => 'dispReplySelectForm()',
		));
		echo __d('circular_notices', 'All Members Belings to this Room'); ?>
		<br />
	<?php foreach ($groups as $group) {
			echo $this->Form->input('CircularNoticeContent.target_group',
			array(
				// 'class' => 'form-control',
				'div' => false,
				'type' => 'checkbox',
				'label' => false,
				'value' => $group['id'],
//				'ng-model' => 'circularNoticeContentReplyType',
//				'ng-change' => 'dispReplySelectForm()',
			));
			echo $group['groupName']; ?>
			<br />
	<?php } ?>
</div>
