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

<div class="form-group" ng-controller="CircularNoticeTarget" ng-init="initialize(1)">
	<div>
		<?php echo $this->Form->label(
			'CircularNoticeContent.userId',
			__d('circular_notices', 'Circular Target') . $this->element('NetCommons.required')
		); ?>
	</div>
	<div class="col-xs-offset-1 col-xs-11" style="margin-bottom: 10px;">
		<?php
//		echo $this->NetCommonsForm->input('CircularNoticeContent.is_room_targeted_flag', array(
//			'legend' => false,
//			'div' => 'nc-circular-notices-target-label',
//			'class' => 'nc-circular-notices-target-radio',
//			'type' => 'radio',
////			'label' => true,
////			'error' => false,
////			'multiple' => 'checkbox',
//			'separator' => '<br />',
//			'value' => (isset($circularNoticeContent['isRoomTargetedFlag'])) ? $circularNoticeContent['isRoomTargetedFlag'] : 1,
//			'options' => array(
//				'1' => __d('circular_notices', 'All Members Belings to this Room'),
//				'0' => __d('circular_notices', '個別に選択'),
//			),
//			'ng-click' => 'target=0',
//		));
		$options = array(
			'1' => __d('circular_notices', 'All Members Belings to this Room'),
			'0' => __d('circular_notices', '個別に選択'),
		);
		echo $this->NetCommonsForm->radio('CircularNoticeContent.is_room_targeted_flag', $options, array(
			'legend' => false,
//			'div' => 'nc-circular-notices-target-label',
//			'class' => 'nc-circular-notices-target-radio',
//			'type' => 'radio',
			'separator' => '<br />',
			'value' => (isset($circularNoticeContent['isRoomTargetedFlag'])) ? $circularNoticeContent['isRoomTargetedFlag'] : 1,
			'ng-click' => 'switchTarget($event)',
		));
		?>
<!--		--><?php
//			$options = array();
//			foreach ($groups as $group) :
//				$options[$group['group']['id']] = $group['group']['name'];
//			endforeach;
//			echo $this->Form->input('CircularNoticeContent.target_groups', array(
//				'div' => false,
//				'type' => 'select',
//				'label' => false,
//				'error' => false,
//				'multiple' => 'checkbox',
//				'selected' => $circularNoticeContent['targetGroups'],
//				'options' => $options,
//			));
//		?>
		<!-- グループ選択 -->
		<div ng-show="target==0">
			<?php echo $this->element('Groups.select',
				array(
					'title' => 'ユーザ選択',
					'pluginModel' => 'CircularNoticeTargetUser',
				));
			?>
		</div>

	</div>
<!--	<div>-->
<!--		--><?php //echo $this->element(
//			'NetCommons.errors', [
//				'errors' => $this->validationErrors,
//				'model' => 'CircularNoticeContent',
//				'field' => 'is_room_targeted_flag',
//			]); ?>
<!--	</div>-->
	
	
<!--	--><?php //echo $this->element('Groups.select_users'); ?>
	
	
<!--	<div class="col-xs-offset-1 col-xs-11">-->
<!--		<div>-->
<!--			<label for="nc-circular-notices-target-all---><?php //echo (int)$frameId; ?><!--" class="nc-circular-notices-target-label" onclick="">-->
<!--				<input id="nc-circular-notices-target-all---><?php //echo (int)$frameId; ?><!--" class="nc-circular-notices-target-radio" type="radio" name="target" value="1" checked="checked" ng-click="target=1" />-->
<!--				ルームに参加するすべてのユーザを対象にする-->
<!--			</label>-->
<!--		</div>-->
<!--		<div>-->
<!--			<label for="nc-circular-notices-target-select---><?php //echo (int)$frameId; ?><!--" class="nc-circular-notices-target-label" onclick="">-->
<!--				<input id="nc-circular-notices-target-select---><?php //echo (int)$frameId; ?><!--" class="nc-circular-notices-target-radio" type="radio" name="target" value="2" ng-click="target=2" />-->
<!--				個別に選択する-->
<!--			</label>-->
<!--			<!-- グループ選択 -->
<!--			<div ng-show="target==2">-->
<!--				--><?php //echo $this->element('Groups.select',
////					array(
////						'title' => 'ユーザ選択'
////					));
////				?>
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
	
	
	
	
</div>
