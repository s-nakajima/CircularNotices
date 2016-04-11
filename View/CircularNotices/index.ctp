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
	echo $this->NetCommonsHtml->script(
		array(
			'/circular_notices/js/circular_notices.js'
		),
		array(
			'plugin' => false,
			'once' => true,
			'inline' => false
		)
	);
?>

<?php
	echo $this->NetCommonsHtml->css(
		array(
			'/circular_notices/css/circular_notices.css'
		),
		array(
			'plugin' => false,
			'once' => true,
			'inline' => false
		)
	);
?>

<div class="nc-content-list">

	<?php if (Current::permission('content_creatable')) : ?>
		<div class="clearfix">
			<div class="pull-right">
				<span class="nc-tooltip" tooltip="<?php echo h(__d('net_commons', 'Add')); ?>">
					<?php
					$addUrl = $this->NetCommonsHtml->url(array(
						'controller' => 'circular_notices',
						'action' => 'add',
						'frame_id' => Current::read('Frame.id')
					));
					echo $this->Button->addLink('',
						$addUrl,
						array('tooltip' => __d('net_commons', 'Add')));
					?>

				</span>
			</div>
		</div>

		<hr class="circular-notice-spacer" />
	<?php endif; ?>

	<div class="clearfix">
		<div class="pull-left">
			<?php echo $this->element('CircularNotices/select_status'); ?>
		</div>
		<div class="pull-right">
			<?php echo $this->element('CircularNotices/select_sort'); ?>
			<?php echo $this->element('CircularNotices/select_limit'); ?>
		</div>
	</div>

	<hr />

	<?php if ($circularNoticeContents) : ?>
		<?php foreach ($circularNoticeContents as $circularNoticeContent) : ?>
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="clearfix">
						<div class="pull-left circular-notice-index-status-label">
							<?php echo $this->element('CircularNotices/status_label', array('circularNoticeContent' => $circularNoticeContent)); ?>
						</div>
						<div class="pull-left">
							<?php if (
								($circularNoticeContent['circularNoticeContent']['currentStatus'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_IN_DRAFT
									|| $circularNoticeContent['circularNoticeContent']['currentStatus'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_RESERVED)
									&& $circularNoticeContent['circularNoticeContent']['createdUser'] != Current::read('User.id')
							) : ?>
								<?php echo h($circularNoticeContent['circularNoticeContent']['subject']); ?><br />
							<?php else : ?>
								<?php echo $this->Html->link(
									$circularNoticeContent['circularNoticeContent']['subject'],
									$this->NetCommonsHtml->url(
										array(
											'controller' => 'circular_notices',
											'action' => 'view',
											'key' => $circularNoticeContent['circularNoticeContent']['key']
										)
									)
								);
								?>
							<?php endif; ?>
							<div>
								<?php echo h(__d('circular_notices', 'Circular Content Period Title')); ?>
								<?php echo $this->Date->dateFormat($circularNoticeContent['circularNoticeContent']['publishStart']); ?>
								<?php echo __d('circular_notices', 'Till'); ?>
								<?php echo $this->Date->dateFormat($circularNoticeContent['circularNoticeContent']['publishEnd']); ?>
							</div>
						</div>
						<!-- 編集リンク -->
						<?php if (Current::permission('content_creatable') && $circularNoticeContent['circularNoticeContent']['createdUser'] == Current::read('User.id')) : ?>
							<div class="pull-right" style="margin: 6px 0;">
									<span class="nc-tooltip" tooltip="<?php echo h(__d('net_commons', 'Edit')); ?>">
										<?php echo $this->NetCommonsHtml->link(
											'<span class="glyphicon glyphicon-edit"> </span>',
											$this->NetCommonsHtml->url(
												array(
													'controller' => 'circular_notices',
													'action' => 'edit',
													'key' => $circularNoticeContent['circularNoticeContent']['key']
												)
											),
											array(
												'class' => 'btn btn-sm btn-primary',
												'escape' => false
											)
										);
										?>
									</span>
							</div>
						<?php endif; ?>
						<!-- 閲覧状況・回答状況 -->
						<div class="pull-right" style="margin: 0 16px;">
							<small>
								<?php echo h(__d('circular_notices', 'Read Count Title') . ' ' . h($circularNoticeContent['readCount'])); ?>
								/
								<?php echo h($circularNoticeContent['targetCount']); ?><br />
								<?php echo h(__d('circular_notices', 'Reply Count Title') . ' ' . h($circularNoticeContent['replyCount'])); ?>
								/
								<?php echo h($circularNoticeContent['targetCount']); ?>
							</small>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>

		<?php echo $this->element('NetCommons.paginator'); ?>

	<?php else : ?>
		<?php echo h(__d('circular_notices', 'Circular Content Data Not Found')); ?>
	<?php endif; ?>

</div>
