<?php
/**
 * circular notice index template
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
			'once' => true,
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
			'once' => true,
			'inline' => false
		)
	);
?>

<div class="nc-content-list">

	<div class="clearfix">
		<div class="pull-left">
			<?php echo $this->element('CircularNotices/select_status'); ?>
			<?php echo $this->element('CircularNotices/select_sort'); ?>
			<?php echo $this->element('CircularNotices/select_limit'); ?>
		</div>
		<div class="pull-right">
			<?php if ($contentCreatable) : ?>
				<span class="nc-tooltip" tooltip="<?php echo h(__d('net_commons', 'Add')); ?>">
					<a href="<?php echo $this->Html->url('/circular_notices/circular_notices/add/' . $frameId) ?>" class="btn btn-success">
						<span class="glyphicon glyphicon-plus"> </span>
					</a>
				</span>
			<?php endif; ?>
		</div>
	</div>

	<hr />

	<?php if ($circularNoticeContents) : ?>
		<?php foreach ($circularNoticeContents as $circularNoticeContent) : ?>
			<div class="circular-notice-block row">
				<div class="clearfix">
					<div class="pull-left circular-notice-index-status">
						<?php echo $this->element('CircularNotices/status_label', array('circularNoticeContent' => $circularNoticeContent)); ?>
					</div>
					<div class="pull-left">
						<?php if (
							$circularNoticeContent['circularNoticeContent']['currentStatus'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_IN_DRAFT ||
							$circularNoticeContent['circularNoticeContent']['currentStatus'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_RESERVED
						) : ?>
							<?php echo h($circularNoticeContent['circularNoticeContent']['subject']); ?><br />
						<?php else : ?>
							<a href="<?php echo $this->Html->url('/circular_notices/circular_notices/view/' . $frameId . '/' . $circularNoticeContent['circularNoticeContent']['id']); ?>"><?php echo h($circularNoticeContent['circularNoticeContent']['subject']); ?></a><br />
						<?php endif; ?>
						<small>
							<?php echo h(__d('circular_notices', 'Circular Content Period Title')); ?>
							<?php echo $this->Date->dateFormat($circularNoticeContent['circularNoticeContent']['openedPeriodFrom']); ?>
							～
							<?php echo $this->Date->dateFormat($circularNoticeContent['circularNoticeContent']['openedPeriodTo']); ?>
						</small>
					</div>
					<div class="pull-right">
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
				<?php if ($contentCreatable && $circularNoticeContent['circularNoticeContent']['createdUser'] == $userId) : ?>
					<div>
						<hr />
						<div class="pull-right">
							<span class="nc-tooltip" tooltip="<?php echo h(__d('net_commons', 'Edit')); ?>">
								<a href="<?php echo $this->Html->url('/circular_notices/circular_notices/edit/' . $frameId . '/' . $circularNoticeContent['circularNoticeContent']['id']) ?>" class="btn btn-sm btn-primary">
									<span class="glyphicon glyphicon-edit"> </span>
								</a>
							</span>
						</div>
					</div>
				<?php endif; ?>
			</div>

		<?php endforeach; ?>

		<div class="text-center">
			<?php echo $this->element('NetCommons.paginator', array(
				'url' => Hash::merge(
					array('controller' => 'circular_notices', 'action' => 'index', $frameId),
					$this->Paginator->params['named']
				)
			)); ?>
		</div>

	<?php else : ?>
		<?php echo h(__d('circular_notices', 'Circular Content Data Not Found')); ?>
	<?php endif; ?>

</div>
