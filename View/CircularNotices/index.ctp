<?php
/**
 * CircularNotices view template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Html->script('/circularNotices/js/circular_notices.js'); ?>
<?php echo $this->Html->css('/circularNotices/css/circular_notices.css'); ?>

<div id="nc-circular-notices-<?php echo (int)$frameId; ?>"
	 ng-controller="CircularNotices.view"
	 ng-init="initialize(<?php echo h(json_encode($this->viewVars)); ?>)">

	<?php if ($contentCreatable) : ?>
		<p class="text-right">
			<span class="nc-tooltip" tooltip="<?php echo __d('net_commons', 'Edit'); ?>">
				<a href="<?php echo $this->Html->url('/circular_notices/circular_notices/edit/' . $frameId) ?>" class="btn btn-success">
					<span class="glyphicon glyphicon-plus"> </span>
				</a>
			</span>
			<?php if (Page::isSetting()) : ?>
				<span>
					<a href="<?php echo $this->Html->url('/circular_notices/frame_settings/edit/' . $frameId) ?>" class="btn btn-default">
						<span class="glyphicon glyphicon-cog"> </span>
					</a>
				</span>
			<?php endif; ?>
		</p>
	<?php endif; ?>

	<?php if($circularNoticeContentList) { ?>
	<div>
		<div class="form-inline">
			<?php echo $this->Form->input('contentStatus',
				array(
					'label' => false,
					'type' => 'select',
					'ng-options' => 'status.num as status.label for status in selectOption.contentStatus',
					'class' => 'form-control',
					'ng-model' => 'selectOption.contentStatus',
					'ng-change' => 'selectCategory()',
					'div' => false,
				)); ?>
			<?php echo $this->Form->input('displayOrder',
				array(
					'label' => false,
					'type' => 'select',
					'ng-options' => 'order.num as order.label for order in selectOption.displayOrder',
					'class' => 'form-control',
					'ng-model' => 'selectOption.displayOrder',
					'ng-change' => 'selectCategory()',
					'div' => false,
				)); ?>
		</div>
		<hr>
			<?php foreach($circularNoticeContentList as $circularNoticeContent) { ?>
			<div class="col-md-12 col-xs-12 circular-notice-block">
				<p class="text-left">
					<?php echo $this->element('CircularNotices.status_label',
						array('status' => $circularNoticeContent['circularNoticeContentStatus'])); ?>
					<?php //echo $circularNoticeContent['circularNoticeContentStatus']; ?>
				</p>
				<p class="text-left">
					<?php echo $circularNoticeContent['circularNoticeContent']['subject']; ?><br />
					<?php echo __d('circular_notices', 'Circular Content Period Title'); ?>
					<?php echo date("Y/m/d H:i", strtotime($circularNoticeContent['circularNoticeContent']['openedPeriodFrom'])); ?>
					～
					<?php echo date("Y/m/d H:i", strtotime($circularNoticeContent['circularNoticeContent']['openedPeriodTo'])); ?><br />
					<?php echo __d('circular_notices', 'Read Count Title'); ?> <?php echo $circularNoticeContent['circularNoticeReadCount']; ?>
					/
					<?php echo $circularNoticeContent['circularNoticeTargetCount']; ?><br />
					<?php echo __d('circular_notices', 'Reply Count Title'); ?> <?php echo $circularNoticeContent['circularNoticeReplyCount']; ?>
					/
					<?php echo $circularNoticeContent['circularNoticeTargetCount']; ?>
				</p>
			</div>
			<?php } ?>
		<?php } else {
			echo __d('circular_notices', 'Circular Content Data Not Found');
		} ?>
	</div>
</div>

<?php
//	var_dump($circularNotice);
//	var_dump($circularNoticeFrameSetting);
//	var_dump($circularNoticeContentList);
?>