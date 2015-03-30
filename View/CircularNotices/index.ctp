<?php
/**
 * CircularNotices index template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Html->script('/net_commons/base/js/workflow.js', false); ?>
<?php echo $this->Html->script('/net_commons/base/js/wysiwyg.js', false); ?>
<?php echo $this->Html->script('/circularNotices/js/circular_notices.js'); ?>
<?php echo $this->Html->css('/circularNotices/css/circular_notices.css'); ?>
<div id="nc-circular-notices-<?php echo (int)$frameId; ?>"
	 ng-controller="CircularNotices"
	 ng-init="initCircularNoticeIndex(<?php echo h(json_encode($this->viewVars)); ?>)">

	<?php if ($contentCreatable) { ?>
		<p class="text-right">
			<span class="nc-tooltip" tooltip="<?php echo __d('net_commons', 'Edit'); ?>">
				<a href="<?php echo $this->Html->url('/circular_notices/circular_notices/edit/' . $frameId) ?>" class="btn btn-success">
					<span class="glyphicon glyphicon-plus"> </span>
				</a>
			</span>
			<?php if (Page::isSetting()) { ?>
				<span>
					<a href="<?php echo $this->Html->url('/circular_notices/frame_settings/edit/' . $frameId) ?>" class="btn btn-default">
						<span class="glyphicon glyphicon-cog"> </span>
					</a>
				</span>
			<?php } ?>
		</p>
	<?php } ?>

	<?php if($circularNoticeContentList) { ?>
		<div class="form-inline">
			<?php // コンテンツ作成権限がない場合 ?>
			<?php if (! $contentCreatable) { ?>
				<?php echo $this->Form->select('CircularNoticeContent.narrowDownParams',
					array(
						CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_ALL => __d('circular_notices', 'Display All Contents'),
						CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_UNREAD => __d('circular_notices', 'Display Unread Contents'),
						CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_READ_YET => __d('circular_notices', 'Display Read Yet Contents'),
						CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_REPLIED => __d('circular_notices', 'Display Replied Contents'),
						CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_FIXED => __d('circular_notices', 'Display Fixed Contents'),
					),
					array(
						'label' => false,
						'class' => 'form-control',
						'div' => false,
						'empty' => null,
						'ng-model' => 'narrowDownParams',
					)); ?>
			<?php // コンテンツ作成権限がある場合 ?>
			<?php } else { ?>
				<?php echo $this->Form->select('CircularNoticeContent.narrowDownParams',
					array(
						CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_ALL => __d('circular_notices', 'Display All Contents'),
						CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_APPROVED => __d('circular_notices', 'Display Public Pending Contents'),
						CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_IN_DRAFT => __d('circular_notices', 'Display Draft During Contents'),
						CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_DISAPPROVED  => __d('circular_notices', 'Display Remand Contents'),
						CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_RESERVED => __d('circular_notices', 'Display Reserved Contents'),
						CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_OPEN => __d('circular_notices', 'Display Open Contents'),
						CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_FIXED => __d('circular_notices', 'Display Fixed Contents'),
						CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_CLOSED => __d('circular_notices', 'Display Closed Contents'),
						CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_UNREAD => __d('circular_notices', 'Display Unread Contents'),
						CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_READ_YET => __d('circular_notices', 'Display Read Yet Contents'),
						CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_REPLIED => __d('circular_notices', 'Display Replied Contents'),
					),
					array(
						'class' => 'form-control',
						'div' => false,
						'empty' => null,
						'ng-model' => 'narrowDownParams',
					)); ?>
			<?php } ?>
			<div class="text-right form-inline circular-notice-float-right">
				<?php echo $this->Form->select('CircularNoticeContent.displayOrder',
					array(
						CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_DISPLAY_ORDER_NEW_ARRIVAL => __d('circular_notices', 'Change Sort Order to New Arrival'),
						CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_DISPLAY_ORDER_OLD_ARRIVAL => __d('circular_notices', 'Change Sort Order to Old Arrival'),
						CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_DISPLAY_ORDER_REPLY_DEADLINE_DESC => __d('circular_notices', 'Change Sort Order to Reply Deadline'),
					),
					array(
						'class' => 'form-control',
						'div' => false,
						'empty' => null,
						'ng-model' => 'displayOrder',
					)); ?>

				<?php echo $this->Form->select('CircularNoticeContent.visibleRowCount',
					array(
							1 => "1件",
							5 => "5件",
							10 => "10件",
							20 => "20件",
							50 => "50件",
							100 => "100件",
					),
					array(
						'class' => 'form-control',
						'div' => false,
						'empty' => null,
						'ng-model' => 'visibleRowCount',
					)); ?>
			</div>
		</div>
		<hr class="circular-notice-clear-float">
		<?php foreach($circularNoticeContentList as $circularNoticeContent) { ?>
			<div class="circular-notice-block row">
				<div>
					<div class="circular-notice-index-status">
						<?php echo $this->element('CircularNotices/status_label',
							array('status' => $circularNoticeContent['circularNoticeContentStatus'])); ?>
					</div>
					<div class="circular-notice-index-content">
						<a href="<?php echo $this->Html->url('/circular_notices/circular_notices/view/' . $frameId . '/' . $circularNoticeContent['circularNoticeContent']['id']); ?>"><?php echo $circularNoticeContent['circularNoticeContent']['subject']; ?></a><br />
						<small>
							<?php echo __d('circular_notices', 'Circular Content Period Title'); ?>
							<?php echo date("Y/m/d H:i", strtotime($circularNoticeContent['circularNoticeContent']['openedPeriodFrom'])); ?>
							～
							<?php echo date("Y/m/d H:i", strtotime($circularNoticeContent['circularNoticeContent']['openedPeriodTo'])); ?><br />
						</small>
					</div>
					<div class="circular-notice-index-counter">
						<small>
							<?php echo __d('circular_notices', 'Read Count Title'); ?> <?php echo $circularNoticeContent['circularNoticeReadCount']; ?>
							/
							<?php echo $circularNoticeContent['circularNoticeTargetCount']; ?><br />
							<?php echo __d('circular_notices', 'Reply Count Title'); ?> <?php echo $circularNoticeContent['circularNoticeReplyCount']; ?>
							/
							<?php echo $circularNoticeContent['circularNoticeTargetCount']; ?>
						</small>
					</div>
				</div>
<div>					<?php if ($contentCreatable) { ?>
						<hr class="circular-notice-clear-float circular-notice-index-divider">
						<div class="text-right">
							<span class="nc-tooltip" tooltip="<?php echo __d('net_commons', 'Edit'); ?>">
								<a href="<?php echo $this->Html->url('/circular_notices/circular_notices/edit/' . $frameId . '/' . $circularNoticeContent['circularNoticeContent']['id']) ?>" class="btn btn-sm btn-primary">
									<span class="glyphicon glyphicon-edit"> </span>
								</a>
							</span>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
	<?php } else {
		echo __d('circular_notices', 'Circular Content Data Not Found');
	} ?>
</div>
