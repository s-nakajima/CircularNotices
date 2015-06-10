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

<?php
	$this->Html->script(
		array(
			'/net_commons/js/workflow.js',
			'/net_commons/js/wysiwyg.js',
			'/circularNotices/js/circular_notices.js'
		),
		array(
			'plugin' => false,
			'inline' => false
		)
	);
?>
<?php
	$this->Html->css(
		array(
			'/circularNotices/css/circular_notices.css'
		),
		array(
			'plugin' => false,
			'inline' => false
		)
	);
?>

<div id="nc-circular-notices-<?php echo (int)$frameId; ?>">

	<?php if ($contentCreatable) { ?>
		<p class="text-right">
			<span class="nc-tooltip" tooltip="<?php echo h(__d('net_commons', 'Add')); ?>">
				<a href="<?php echo $this->Html->url('/circular_notices/circular_notices/add/' . $frameId) ?>" class="btn btn-success">
					<span class="glyphicon glyphicon-plus"> </span>
				</a>
			</span>
		</p>
	<?php } ?>

		<div class="form-inline">
			<?php echo $this->element('CircularNotices/select_status'); ?>
			<div class="text-right form-inline circular-notice-float-right">
				<?php echo $this->element('CircularNotices/select_sort'); ?>
				<?php echo $this->element('CircularNotices/select_limit'); ?>
			</div>
		</div>
		<hr class="circular-notice-clear-float">

	<?php if (isset($circularNoticeContentList) && count($circularNoticeContentList) > 0) { ?>
		<?php foreach($circularNoticeContentList as $circularNoticeContent) { ?>
			<div class="circular-notice-block row">
				<div>
					<div class="circular-notice-index-status">
						<?php echo $this->element('CircularNotices/status_label', array('circularNoticeContent' => $circularNoticeContent)); ?>
					</div>
					<div class="circular-notice-index-content">

					<?php if (
						$circularNoticeContent['circularNoticeContent']['currentStatus'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_IN_DRAFT ||
						$circularNoticeContent['circularNoticeContent']['currentStatus'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_RESERVED
					) { ?>
						<?php echo h($circularNoticeContent['circularNoticeContent']['subject']); ?><br />
					<?php } else { ?>
						<a href="<?php echo $this->Html->url('/circular_notices/circular_notices/view/' . $frameId . '/' . $circularNoticeContent['circularNoticeContent']['id']); ?>"><?php echo h($circularNoticeContent['circularNoticeContent']['subject']); ?></a><br />
					<?php } ?>

						<small>
							<?php echo h(__d('circular_notices', 'Circular Content Period Title')); ?>
							<?php echo h($circularNoticeContent['circularNoticeContent']['openedPeriodFrom']); ?>
							～
							<?php echo h($circularNoticeContent['circularNoticeContent']['openedPeriodTo']); ?><br />
						</small>
					</div>
					<div class="circular-notice-index-counter">
						<small>
							<?php echo h(__d('circular_notices', 'Read Count Title')); ?> <?php echo h($circularNoticeContent['readCount']); ?>
							/
							<?php echo h($circularNoticeContent['targetCount']); ?><br />
							<?php echo h(__d('circular_notices', 'Reply Count Title')); ?> <?php echo h($circularNoticeContent['replyCount']); ?>
							/
							<?php echo h($circularNoticeContent['targetCount']); ?>
						</small>
					</div>
				</div>
				<div>
					<?php if ($contentCreatable && $circularNoticeContent['circularNoticeContent']['createdUser'] == $userId) { ?>
						<hr class="circular-notice-clear-float circular-notice-index-divider">
						<div class="text-right">
							<span class="nc-tooltip" tooltip="<?php echo h(__d('net_commons', 'Edit')); ?>">
								<a href="<?php echo $this->Html->url('/circular_notices/circular_notices/edit/' . $frameId . '/' . $circularNoticeContent['circularNoticeContent']['id']) ?>" class="btn btn-sm btn-primary">
									<span class="glyphicon glyphicon-edit"> </span>
								</a>
							</span>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>

		<div class="text-center">
			<?php echo $this->element('NetCommons.paginator', array(
				'url' => Hash::merge(
					array('controller' => 'circular_notices', 'action' => 'index', $frameId),
					$this->Paginator->params['named']
				)
			)); ?>
		</div>

	<?php } else {
		echo h(__d('circular_notices', 'Circular Content Data Not Found'));
	} ?>
</div>
