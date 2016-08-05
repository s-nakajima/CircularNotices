<?php
/**
 * circular notice view template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php
	echo $this->Html->script(
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
	echo $this->Html->css(
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

<header>
	<!-- 編集 -->
	<?php if (Current::permission('content_creatable') && $circularNoticeContent['created_user'] == Current::read('User.id')) : ?>
		<div class="pull-right">
			<div class="text-right">
				<?php echo $this->Button->editLink('',
					array(
						'controller' => 'circular_notices',
						'action' => 'edit',
						'key' => $circularNoticeContent['key']
					),
					array(
						'tooltip' => true,
					)
				); ?>
			</div>
		</div>
	<?php endif; ?>
</header>

<div id="nc-circular-notices-<?php echo (int)Current::read('Frame.id'); ?>" ng-controller="CircularNoticeView" ng-init="initialize()">
	<article>
		<div class="clearfix">
			<?php $title = h($circularNoticeContent['subject']) . '<small>' . $this->element('CircularNotices/status_label', array('circularNoticeContent' => $circularNoticeContent)) . '</small>'; ?>
			<?php echo $this->NetCommonsHtml->blockTitle($title,
				$circularNoticeContent['title_icon'], ['escape' => false]); ?>
		</div>
	
		<div class="clearfix">
			<div class="pull-left">
				<?php echo h(__d('circular_notices', 'Circular Content Period Title')); ?>
				<?php echo $this->Date->dateFormat($circularNoticeContent['publish_start']); ?>
				～
				<?php echo $this->Date->dateFormat($circularNoticeContent['publish_end']); ?><br />
				<?php echo h(__d('circular_notices', 'Created User Title')); ?>
				<?php echo $this->NetCommonsHtml->handleLink(array('User' => Current::read('User')), array('avatar' => true), array(), 'User'); ?><br />
			</div>
			<div class="pull-right">
				<?php echo h(__d('circular_notices', 'Read Count Title') . ' ' . h($readCount)); ?>
				/
				<?php echo h($targetCount); ?><br />
				<?php echo h(__d('circular_notices', 'Reply Count Title') . ' ' . h($replyCount)); ?>
				/
				<?php echo h($targetCount); ?><br />
			</div>
		</div>
	
		<hr />
	
		<div>
			<?php echo $circularNoticeContent['content']; ?>
		</div>
	
		<?php if ($circularNoticeContent['reply_type'] != CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT) : ?>
			<div class="clearfix">
				<div class="pull-left">
					<?php echo h(__d('circular_notices', 'Choices Title')); ?>
				</div>
				<div class="pull-left">
					<?php foreach ($circularNoticeChoice as $choice) : ?>
						<?php echo h($choice['value']); ?><br />
					<?php endforeach; ?>
				</div>
				<div>
					<?php foreach ($circularNoticeChoice as $choice) : ?>
						<?php echo h(__d('circular_notices', 'Selected Count', isset($answersSummary[$choice['value']]) ? $answersSummary[$choice['value']] : 0)); ?><br />
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	
		<?php if (
			$circularNoticeContent['current_status'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_OPEN &&
			isset($myAnswer['CircularNoticeTargetUser']['user_status'])
		) : ?>
	
			<hr />
	
			<div>
				<hr class="circular-notice-spacer" />
	
				<?php echo $this->NetCommonsForm->create('CircularNoticeTargetUser', array(
					'name' => 'form',
					'novalidate' => true,
				)); ?>
				<?php echo $this->NetCommonsForm->hidden('CircularNoticeContent.key', array(
					'value' => $circularNoticeContent['key'],
				)); ?>
	
					<div class="panel panel-default">
						<div class="panel-heading">
							<?php echo h(__d('circular_notices', 'Answer Title')); ?>
						</div>
						<div class="panel-body">
							<div class="form-group">
	
							<?php echo $this->NetCommonsForm->hidden('CircularNoticeTargetUser.id', array(
								'value' => $myAnswer['CircularNoticeTargetUser']['id'],
							)); ?>
	
							<?php
							switch ($circularNoticeContent['reply_type']) {
								case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT:
									echo $this->NetCommonsForm->input('CircularNoticeTargetUser.reply_text_value', array(
											'type' => 'textarea',
											'label' => '',
											'error' => false,
											'class' => 'form-control nc-noresize',
											'value' => $myAnswer['CircularNoticeTargetUser']['reply_text_value'],
											'placeholder' => '',
											'div' => true,
											));
									break;
								case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION:
									$selections = array();
									foreach ($circularNoticeChoice as $choice) :
										$selections[$choice['value']] = $choice['value'];
									endforeach;
									echo $this->NetCommonsForm->input('CircularNoticeTargetUser.reply_selection_value', array(
										'div' => false,
										'type' => 'radio',
										'legend' => false,
										'label' => false,
										'value' => $myAnswer['CircularNoticeTargetUser']['reply_selection_value'],
										'options' => $selections,
									));
									break;
								case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION:
									$selections = array();
									foreach ($circularNoticeChoice as $choices) :
										$selections[$choices['value']] = $choices['value'];
									endforeach;
									$selected = explode(CircularNoticeComponent::SELECTION_VALUES_DELIMITER, $myAnswer['CircularNoticeTargetUser']['reply_selection_value']);
									echo $this->NetCommonsForm->input('CircularNoticeTargetUser.reply_selection_value', array(
										'div' => false,
										'type' => 'select',
										'legend' => true,
										'label' => false,
										'multiple' => 'checkbox',
										'selected' => $selected,
										'options' => $selections,
										'class' => 'form-input',
									));
									break;
							}
							?>
							<?php echo $this->NetCommonsForm->error('CircularNoticeTargetUser.reply_text_value'); ?>

							</div>
						</div>

						<div class="panel-footer text-center">
							<?php
								echo $this->BackTo->linkButton(
										__d('net_commons', 'Cancel'), NetCommonsUrl::backToPageUrl(false));
								if (! $myAnswer['CircularNoticeTargetUser']['is_reply']):
									$labelName = __d('circular_notices', 'Answer');
									$tooltip = __d('circular_notices', 'Do Answer');
								else:
									$labelName = __d('circular_notices', 'Change Answer');
									$tooltip = __d('circular_notices', 'Change Answer');
								endif;
							?>
							<span class="nc-tooltip" tooltip="<?php echo h($tooltip); ?>">
								<button type="submit" class="btn btn-primary"
									ng-click="this.form.submit();"
									ng-disabled="sending">
									<?php echo h($labelName); ?>
								</button>
							</span>
						</div>
					</div>
	
				<?php echo $this->NetCommonsForm->end(); ?>
	
			</div>
	
		<?php endif; ?>
	
		<hr />
	
		<div class="text-right">
	
			<span class="nc-tooltip" tooltip="<?php echo h(__d('circular_notices', 'Show Other Users')); ?>">
				<button type="button" class="btn btn-default"
					ng-click="switchOtherUserView(true)"
					ng-hide="showOtherUsers!=false">
					<span class="glyphicon glyphicon-menu-right"></span>
					<?php echo h(__d('circular_notices', 'Show Other Users')); ?>
				</button>
			</span>
	
			<span class="nc-tooltip" tooltip="<?php echo h(__d('circular_notices', 'Close Other Users')); ?>">
				<button type="button" class="btn btn-default"
					ng-click="switchOtherUserView(false)"
					ng-hide="showOtherUsers!=true">
					<span class="glyphicon glyphicon-menu-down"></span>
					<?php echo h(__d('circular_notices', 'Close Other Users')); ?>
				</button>
			</span>
	
		</div>
	
		<hr class="circular-notice-spacer" />
	
		<div ng-hide="showOtherUsers!=true">
	
			<div class="clearfix">
				<div class="pull-left">
	<!--				--><?php //echo $this->element('CircularNotices/view_select_sort'); ?>
					<?php echo $this->element('CircularNotices/view_select_limit'); ?>
				</div>
				<div class="pull-right">
					<span class="nc-tooltip" tooltip="<?php echo h(__d('circular_notices', 'Download')); ?>">
						<button type="button" class="btn btn-success"
							onclick="location.href='<?php echo NetCommonsUrl::actionUrl(array(
								'plugin' => 'circular_notices',
								'controller' => 'circular_notices',
								'action' => 'download',
								'block_id' => Current::read('Block.id'),
								'key' => $circularNoticeContent['key'],
								'frame_id' => Current::read('Frame.id'))); ?>'">
							<span class="glyphicon glyphicon-download">
								<?php echo h(__d('circular_notices', 'Other Users Csv')); ?>
							</span>
						</button>
					</span>
				</div>
			</div>
	
			<hr class="circular-notice-spacer" />
	
			<!-- 回覧先と回答 -->
			<table class="table table-hover">
				<thead>
					<tr>
						<th>
							<?php echo $this->Paginator->sort('User.handlename', h(__d('circular_notices', 'Target User'))); ?>
						</th>
						<th>
							<?php echo $this->Paginator->sort('CircularNoticeTargetUser.read_datetime', h(__d('circular_notices', 'Read Datetime'))); ?>
						</th>
						<th>
							<?php echo $this->Paginator->sort('CircularNoticeTargetUser.reply_datetime', h(__d('circular_notices', 'Reply Datetime'))); ?>
						</th>
						<th>
							<?php
								switch ($circularNoticeContent['reply_type']) {
									case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT:
										$replyType = 'reply_text_value';
										break;
									case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION:
									case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION:
										$replyType = 'reply_selection_value';
										break;
								}
								echo $this->Paginator->sort('CircularNoticeTargetUser.' . $replyType, h(__d('circular_notices', 'Answer')));
							?>
						</th>
					</tr>
				</thead>
				<?php
					foreach ($circularNoticeTargetUsers as $circularNoticeTargetUser) :
						$answer = null;
						switch ($circularNoticeContent['reply_type']) {
							case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT:
								$answer = $circularNoticeTargetUser['CircularNoticeTargetUser']['reply_text_value'];
								break;
							case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION:
							case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION:
								$selectionValues = explode(CircularNoticeComponent::SELECTION_VALUES_DELIMITER, $circularNoticeTargetUser['CircularNoticeTargetUser']['reply_selection_value']);
								$answer = implode('、', $selectionValues);
								break;
						}

						if (! $circularNoticeTargetUser['CircularNoticeTargetUser']['read_datetime']) :
							$readDatetime = __d('circular_notices', 'Unread');
						else :
							$readDatetime = $this->Date->dateFormat($circularNoticeTargetUser['CircularNoticeTargetUser']['read_datetime']);
						endif;

						if (! $circularNoticeTargetUser['CircularNoticeTargetUser']['reply_datetime']) :
							$replyDatetime = __d('circular_notices', 'Unreply');
						else :
							$replyDatetime = $this->Date->dateFormat($circularNoticeTargetUser['CircularNoticeTargetUser']['reply_datetime']);
						endif;

						echo $this->Html->tableCells(array(
							$this->NetCommonsHtml->handleLink($circularNoticeTargetUser, array(), array(), 'User'),
							h($readDatetime),
							h($replyDatetime),
							h($answer),
						));
					endforeach;
				?>
			</table>

			<?php echo $this->element('NetCommons.paginator'); ?>
		</div>
	</article>
</div>
