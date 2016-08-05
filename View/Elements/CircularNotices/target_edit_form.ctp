<?php
/**
 * circular notice edit target element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>
<?php
	$circularNoticeContent['is_room_target'] = ($circularNoticeContent['is_room_target']) ? 1 : 0;
?>
<div class="form-group" ng-controller="CircularNoticeTarget" ng-init="initialize(<?php echo $circularNoticeContent['is_room_target']; ?>)">
	<div>
		<?php echo $this->NetCommonsForm->label(
			'CircularNoticeContent.userId',
			__d('circular_notices', 'Circular Target') . $this->element('NetCommons.required')
		); ?>
	</div>
	<div style="margin-bottom: 10px;">
		<?php
		$options = array(
			'1' => __d('circular_notices', 'All Members Belings to this Room'),
			'0' => __d('circular_notices', 'Individually User Selected'),
		);
		echo $this->NetCommonsForm->radio('CircularNoticeContent.is_room_target', $options, array(
			'value' => $circularNoticeContent['is_room_target'],
			'ng-click' => 'switchTarget($event)',
			'outer' => false,
		));
		?>
		<?php echo $this->NetCommonsForm->error('CircularNoticeTargetUser.user_id'); ?>
	</div>
	<!-- グループ選択 -->
	<div ng-show="target==0" class="col-xs-12">
		<?php
			$title = __d('circular_notices', 'Circulation Destination User Selection');
			$pluginModel = 'CircularNoticeTargetUser';
			$roomId = Current::read('Room.id');
			$selectUsers = (isset($this->request->data['selectUsers'])) ? $this->request->data['selectUsers'] : null;
			echo $this->GroupUserList->select($title, $pluginModel, $roomId, $selectUsers);
		?>
	</div>
</div>
