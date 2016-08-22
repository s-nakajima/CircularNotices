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
	echo $this->NetCommonsHtml->script(
		array(
			'/circular_notices/js/circular_notices.js'
		)
	);
?>
<?php
	echo $this->NetCommonsHtml->css(
		array(
			'/circular_notices/css/circular_notices.css'
		)
	);
?>

<header class="clearfix">
	<div class="pull-left">
		<?php echo $this->element('CircularNotices/status_label', array('circularNoticeContent' => $circularNoticeContent)); ?>
	</div>
	<?php if (Current::permission('content_creatable')) : ?>
		<div class="pull-right">
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
	<?php endif; ?>
</header>

<article>
	<div id="nc-circular-notices-<?php echo (int)Current::read('Frame.id'); ?>" ng-controller="CircularNoticeView" ng-init="initialize()">
		<div class="clearfix circular-notices-word-break">
			<?php echo $this->NetCommonsHtml->blockTitle($circularNoticeContent['subject'],
				$circularNoticeContent['title_icon']); ?>
		</div>

		<div class="clearfix">
			<div class="pull-left">
				<div class="circular-notice-publish-period">
					<?php echo __d('circular_notices', 'Circular Content Period Title'); ?>
					<?php echo $this->CircularNotice->displayDate($circularNoticeContent['publish_start']); ?>
					<?php echo __d('circular_notices', 'Till'); ?>
					<?php echo $this->CircularNotice->displayDate($circularNoticeContent['publish_end']); ?><br />
				</div>
				<div class="circular-notice-answer-deadline">
					<?php echo __d('circular_notices', 'Circular Content Deadline Title'); ?>
					<?php 
						$replyDeadline = __d('circular_notices', 'Not Date Set');
						if (!empty($circularNoticeContent['reply_deadline'])):
							$replyDeadline = $this->CircularNotice->displayDate($circularNoticeContent['reply_deadline']);
						endif;
						echo $replyDeadline;
					?>
				</div>
				<div class="circular-notice-created-user">
					<?php echo __d('circular_notices', 'Created User Title'); ?>
					<?php echo $this->NetCommonsHtml->handleLink(array('User' => Current::read('User')), array('avatar' => true), array(), 'User'); ?><br />
				</div>
			</div>
			<!-- 閲覧状況・回答状況 -->
			<div class="pull-right">
				<?php echo __d('circular_notices', 'Read Count Title'); ?>
				<span class="circular-notices-answer-count-molecule">
					<?php echo $readCount; ?>
				</span>
				<?php echo __d('circular_notices', 'Division bar'); ?>
				<span class="circular-notices-answer-count-denominator">
					<?php echo $targetCount; ?>
				</span>
				<br />
				<?php echo __d('circular_notices', 'Reply Count Title'); ?>
				<span class="circular-notices-answer-count-molecule">
					<?php echo $replyCount; ?>
				</span>
				<?php echo __d('circular_notices', 'Division bar'); ?>
				<span class="circular-notices-answer-count-denominator">
					<?php echo $targetCount; ?>
				</span>
			</div>
		</div>

		<div class="circular-notices-content circular-notices-word-break">
			<p>
				<?php echo $circularNoticeContent['content']; ?>
			</p>
		</div>

		<?php if ($circularNoticeContent['reply_type'] != CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT) : ?>
			<div class="clearfix circular-notice-answer-choice">
				<div class="pull-left">
					<?php echo __d('circular_notices', 'Choices Title'); ?>
				</div>
				<div class="pull-left circular-notice-answer-choice-choices">
					<?php foreach ($circularNoticeChoice as $choice) : ?>
						<?php echo $choice['value']; ?><br />
					<?php endforeach; ?>
				</div>
				<div>
					<?php foreach ($circularNoticeChoice as $choice) : ?>
						<?php echo __d('circular_notices', 'Selected Count', isset($answersSummary[$choice['id']]) ? $answersSummary[$choice['id']] : 0); ?><br />
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if (
			$circularNoticeContent['content_status'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_OPEN &&
			isset($myAnswer['CircularNoticeTargetUser']['reply_status'])
		) : ?>

			<div>
				<?php echo $this->NetCommonsForm->create('CircularNoticeTargetUser', array(
					'name' => 'form',
					'novalidate' => true,
					'type' => 'post',
					'url' => NetCommonsUrl::actionUrl(array(
						'plugin' => 'circular_notices',
						'controller' => 'circular_notices_answer',
						'action' => 'edit',
						'key' => $circularNoticeContent['key'],
						'block_id' => Current::read('Block.id'),
						'frame_id' => Current::read('Frame.id'),
					))
					)); ?>
				<?php echo $this->NetCommonsForm->hidden('CircularNoticeContent.key', array(
					'value' => $circularNoticeContent['key'],
				)); ?>

					<div class="panel panel-default">
						<div class="panel-heading">
							<?php echo __d('circular_notices', 'Answer Title'); ?>
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
									$selected = '';
									foreach ($circularNoticeChoice as $choice) :
										$selections[$choice['id']] = $choice['value'];
										if ($choice['id'] === $myAnswer['CircularNoticeTargetUser']['reply_selection_value']) :
											$selected = $choice['id'];
										endif;
									endforeach;
									echo $this->NetCommonsForm->input('CircularNoticeTargetUser.reply_selection_value', array(
										'div' => false,
										'type' => 'radio',
										'legend' => false,
										'label' => false,
										'value' => $selected,
										'options' => $selections,
									));
									break;
								case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION:
									$selections = array();
									$selected = explode(CircularNoticeComponent::SELECTION_VALUES_DELIMITER, $myAnswer['CircularNoticeTargetUser']['reply_selection_value']);
									$selectedValue = array();
									foreach ($circularNoticeChoice as $choices) :
										$selections[$choices['id']] = $choices['value'];
										if (in_array($choices['id'], $selected, true)) :
											$selectedValue[] = $choices['value'];
										endif;
									endforeach;
									$selected = explode(CircularNoticeComponent::SELECTION_VALUES_DELIMITER, $myAnswer['CircularNoticeTargetUser']['reply_selection_value']);
									echo $this->Form->input('CircularNoticeTargetUser.reply_selection_value', array(
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
								if (! $myAnswer['CircularNoticeTargetUser']['is_reply']):
									$labelName = __d('circular_notices', 'Answer');
								else:
									$labelName = __d('circular_notices', 'Change Answer');
								endif;
								echo $this->Button->cancelAndSave(
									__d('net_commons', 'Cancel'),
									$labelName,
									NetCommonsUrl::backToPageUrl(false)
								);
							?>
						</div>
					</div>

				<?php echo $this->NetCommonsForm->end(); ?>

			</div>

		<?php endif; ?>

		<div class="text-right">

			<span class="nc-tooltip" tooltip="<?php echo __d('circular_notices', 'Show Other Users'); ?>">
				<button type="button" class="btn btn-default"
					ng-click="switchOtherUserView(true)"
					ng-hide="showOtherUsers!=false">
					<span class="glyphicon glyphicon-menu-right"></span>
					<?php echo __d('circular_notices', 'Show Other Users'); ?>
				</button>
			</span>

			<span class="nc-tooltip" tooltip="<?php echo __d('circular_notices', 'Close Other Users'); ?>">
				<button type="button" class="btn btn-default"
					ng-click="switchOtherUserView(false)"
					ng-hide="showOtherUsers!=true">
					<span class="glyphicon glyphicon-menu-down"></span>
					<?php echo __d('circular_notices', 'Close Other Users'); ?>
				</button>
			</span>

		</div>

		<div class="circular-notices-show-other-users" ng-hide="showOtherUsers!=true">

			<div class="clearfix">
				<div class="pull-left">
					<?php echo $this->DisplayNumber->dropDownToggle(); ?>
				</div>
				<div class="pull-right">
					<span class="nc-tooltip" tooltip="<?php echo h(__d('circular_notices', 'Download')); ?>">
						<?php echo $this->AuthKeyPopupButton->popupButton(
							array(
								'url' => NetCommonsUrl::actionUrl(array(
									'plugin' => 'circular_notices',
									'controller' => 'circular_notices',
									'action' => 'download',
									'block_id' => Current::read('Block.id'),
									'key' => $circularNoticeContent['key'],
									'frame_id' => Current::read('Frame.id'),
								)),
								'label' => h(__d('circular_notices', 'Other Users Csv')),
								'popup-title' => __d('authorization_keys', 'Compression password'),
								'popup-label' => __d('authorization_keys', 'Compression password'),
								'popup-placeholder' => __d('authorization_keys', 'please input compression password'),
							)
						)?>
					</span>
				</div>
			</div>

			<!-- 回覧先と回答 -->
			<table class="table table-hover circular-notices-target-users-list">
				<thead>
					<tr>
						<th>
							<?php echo $this->Paginator->sort('User.handlename', __d('circular_notices', 'Target User')); ?>
						</th>
						<th class="row-datetime">
							<?php echo $this->Paginator->sort('CircularNoticeTargetUser.read_datetime', __d('circular_notices', 'Read Datetime')); ?>
						</th>
						<th class="row-datetime">
							<?php echo $this->Paginator->sort('CircularNoticeTargetUser.reply_datetime', __d('circular_notices', 'Reply Datetime')); ?>
						</th>
						<th class="circular-notices-reply-col">
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
								echo $this->Paginator->sort('CircularNoticeTargetUser.' . $replyType, __d('circular_notices', 'Answer'));
							?>
						</th>
					</tr>
				</thead>
				<?php
					foreach ($circularNoticeTargetUsers as $circularNoticeTargetUser) :
						$answer = null;
						switch ($circularNoticeContent['reply_type']) {
							case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT:
								$answer = nl2br(h($circularNoticeTargetUser['CircularNoticeTargetUser']['reply_text_value']));
								break;
							case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION:
							case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION:
								$selectionValues = explode(CircularNoticeComponent::SELECTION_VALUES_DELIMITER, $circularNoticeTargetUser['CircularNoticeTargetUser']['reply_selection_value']);
								$answerValueArr = array();
								foreach ($selectionValues as $selectionValue) :
									if (isset($selections[$selectionValue])) :
										$answerValueArr[] = $selections[$selectionValue];
									endif;
								endforeach;
								$answer = implode(__d('circular_notices', 'Answer separator'), $answerValueArr);
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
							$this->NetCommonsHtml->handleLink($circularNoticeTargetUser, array('avatar' => true), array(), 'User'),
							array($readDatetime, array('class' => 'row-datetime')),
							array($replyDatetime, array('class' => 'row-datetime')),
							array($answer, array('class' => 'circular-notices-reply-col circular-notices-word-break')),
						));
					endforeach;
				?>
			</table>

			<?php echo $this->element('NetCommons.paginator'); ?>
		</div>
	</div>
</article>
