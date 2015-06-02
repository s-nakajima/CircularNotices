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

<div id="nc-circular-notices-<?php echo (int)$frameId; ?>"
	 ng-controller="CircularNotices"
	 ng-init="initCircularNoticeView(<?php echo h(json_encode($this->viewVars['circularNoticeContent']['answer'])) ?>,
	 								 <?php echo h(json_encode($this->viewVars['circularNoticeChoices'])); ?>)">

	<div class="modal-header">
		<?php echo h(__d('circular_notices', 'Plugin Name')); ?>
	</div>

	<div class="panel panel-default">
		<div class="panel-body">

			<div class="circular-notice-index-content">
				<?php echo h($circularNoticeContent['subject']); ?><br />
				<div class="circular-notice-indent">
					<?php echo h(__d('circular_notices', 'Circular Content Period Title')); ?>
					<?php echo h($circularNoticeContent['openedPeriodFrom']); ?>
					～
					<?php echo h($circularNoticeContent['openedPeriodTo']); ?><br />
					<?php echo h(__d('circular_notices', 'Created User Title')); ?>
					<?php echo h($user['username']); ?><br />
				</div>
			</div>

			<div class="circular-notice-index-counter">
				<?php echo h(__d('circular_notices', 'Read Count Title')); ?> <?php echo h($circularNoticeReadCount); ?>
				/
				<?php echo h($circularNoticeTargetCount); ?><br />
				<?php echo h(__d('circular_notices', 'Reply Count Title')); ?> <?php echo h($circularNoticeReplyCount); ?>
				/
				<?php echo h($circularNoticeTargetCount); ?><br />
			</div>

			<hr class="circular-notice-clear-float">

			<div>
				<?php echo $circularNoticeContent['content']; ?>
			</div>

			<hr class="circular-notice-clear-float">

			<div>
				<?php echo h(__d('circular_notices', 'Reply Type Title')); ?>
				<?php switch($circularNoticeContent['replyType']) {
					case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT:
						echo h(__d('circular_notices', 'Reply Type Text'));
						break;
					case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION:
						echo h(__d('circular_notices', 'Reply Type Selection'));
						break;
					case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION:
						echo h(__d('circular_notices', 'Reply Type Multiple Selection'));
						break;
				}?>
			</div>

			<?php if ($circularNoticeContent['replyType'] != CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT) { ?>
				<div class="circular-notice-box-left">
					<?php echo h(__d('circular_notices', 'Choices Title')); ?>
				</div>
				<div class="circular-notice-box-left">
					<?php foreach ($circularNoticeChoice as $choice) { ?>
						<?php echo h($choice['value']); ?>
						<br />
					<?php } ?>
				</div>


				<div class="circular-notice-box-left">
					<?php foreach ($circularNoticeChoices as $circularNoticeChoice) { ?>
						<?php echo h($circularNoticeChoice['circularNoticeChoice']['value']); ?>
						<br />
					<?php } ?>
				</div>
				<div>
					<?php foreach ($circularNoticeChoices as $circularNoticeChoice) { ?>
						<?php echo h(__d('circular_notices', 'Selected Count', $circularNoticeChoice['circularNoticeChoice']['selectedCount'])); ?>
						<br />
					<?php } ?>
				</div>
			<?php } ?>

			<hr class="circular-notice-clear-float">

			<div>

				<?php echo h(__d('circular_notices', 'Answer Title')); ?>
				<?php switch ($circularNoticeContent['replyType']) {
					case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT:
						echo h($myAnswer['circularNoticeTargetUser']['replyTextValue']);
						break;
					case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION:
					case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION:
						echo h(implode('、', $myAnswer['circularNoticeTargetUser']['replySelectionValue']));
						break;
				} ?>

				<?php if (
					! $circularNoticeContent['replyDeadlineSetFlag'] ||
					($circularNoticeContent['replyDeadlineSetFlag'] && $circularNoticeContent['replyDeadline'] > date("Y-m-d H:i:s", time()))
				) { ?>

					<?php echo $this->Form->create('CircularNoticeTargetUser', array(
						'name' => 'form',
						'novalidate' => true,
					)); ?>

					<div class="circular-notice-block" ng-hide="showReplyForm==false">
						<div class="form-inline">

							<?php echo $this->Form->hidden('CircularNoticeTargetUser.id', array(
								'value' => $myAnswer['circularNoticeTargetUser']['id'],
							)); ?>

							<?php switch ($circularNoticeContent['replyType']) {
								case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT:
									echo $this->Form->input('CircularNoticeTargetUser.reply_text_value', array(
										'type' => 'text',
										'label' => '',
										'error' => false,
										'class' => 'form-control',
										'value' => $myAnswer['circularNoticeTargetUser']['replyTextValue'],
										'placeholder' => '',
										'div' => true,
									));
									break;
								case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION:
									$selections = array();
									foreach ($circularNoticeChoice as $choice) {
										$selections[$choice['value']] = $choice['value'];
									}
									echo $this->Form->input('CircularNoticeTargetUser.reply_selection_value', array(
										'class' => 'form-control',
										'div' => false,
										'type' => 'radio',
										'legend' => false,
										'label' => true,
										'value' => ($myAnswer['circularNoticeTargetUser']['replySelectionValue'] ? $myAnswer['circularNoticeTargetUser']['replySelectionValue'][0] : null),
										'options' => $selections,
									));
									break;
								case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION:
									$selections = array();
									foreach ($circularNoticeChoice as $choices) {
										$selections[$choices['value']] = $choices['value'];
									}
									echo $this->Form->input('CircularNoticeTargetUser.reply_selection_value', array(
										'class' => 'circular-notice-checkbox',
										'div' => false,
										'type' => 'select',
										'label' => false,
										'multiple' => 'checkbox',
										'selected' => $myAnswer['circularNoticeTargetUser']['replySelectionValue'],
										'options' => $selections,
									));
									break;
							} ?>
					</div>
				<?php } ?>
			</div>

			<?php if ($circularNoticeContent['replyDeadlineSetFlag'] == false ||
					 ($circularNoticeContent['replyDeadlineSetFlag'] == true && $circularNoticeContent['replyDeadline'] > date("Y-m-d H:i:s", time()))) { ?>
				<p class="text-center">
					<?php if (! $myAnswer['circularNoticeTargetUser']['replyFlag']) { ?>
						<span class="nc-tooltip" tooltip="<?php echo h(__d('circular_notices', 'Do Answer')); ?>">
							<button type="button" class="btn btn-success"
								ng-click="switchReplyForm(true);"
								ng-hide="showReplyForm!=false"
								ng-disabled="sending">
								<span class="glyphicon glyphicon-plus"></span>
								<?php echo h(__d('circular_notices', 'Answer')); ?>
							</button>
						</span>
					<?php } else { ?>
						<span class="nc-tooltip" tooltip="<?php echo h(__d('circular_notices', 'Change Answer')); ?>">
							<button type="button" class="btn btn-primary"
								ng-click="switchReplyForm(true);"
								ng-hide="showReplyForm!=false"
								ng-disabled="sending">
								<span class="glyphicon glyphicon-edit"></span>
								<?php echo h(__d('circular_notices', 'Change Answer')); ?>
							</button>
						</span>
					<?php } ?>
					<button type="button" class="btn btn-default"
						ng-click="switchReplyForm(false);"
						ng-hide="showReplyForm!=true"
						ng-disabled="sending">
						<span class="glyphicon glyphicon-remove"></span>
						<?php echo h(__d('net_commons', 'Cancel')); ?>
					</button>

					<button type="submit" class="btn btn-primary"
						ng-click="this.form.submit();"
						ng-hide="showReplyForm!=true"
						ng-disabled="sending">
						<span class="glyphicon glyphicon-remove"></span>
						<?php echo h(__d('net_commons', 'OK')); ?>
					</button>
				</p>
				<?php echo $this->Form->end(); ?>
			<?php } ?>

			<hr class="circular-notice-clear-float">
			<div class="circular-notice-block text-center" ng-hide="showOtherUsers!=false" ng-click="switchOtherUserView(true)">
				<?php echo h(__d('circular_notices', 'Show Other Users')); ?>
			</div>
			<div class="circular-notice-block text-center" ng-hide="showOtherUsers!=true" ng-click="switchOtherUserView(false)">
				<?php echo h(__d('circular_notices', 'Close Other Users')); ?>
			</div>



			<div ng-hide="showOtherUsers!=true">
				<div class="form-inline">
					<div class="text-right form-inline circular-notice-float-right">
						<?php echo $this->element('CircularNotices/view_select_sort'); ?>
						<?php echo $this->element('CircularNotices/view_select_limit'); ?>
					</div>
				</div>
				<hr class="circular-notice-clear-float">

				<table class="table table-bordered">
					<?php echo $this->Html->tableHeaders(
							array(
								h(__d('circular_notices', 'Target User')),
								h(__d('circular_notices', 'Read Datetime')),
								h(__d('circular_notices', 'Reply Datetime')),
								h(__d('circular_notices', 'Answer')),
							),
							array('class' => 'circular-notice-target-users-header')
						);
						foreach ($circularNoticeTargetUsers as $circularNoticeTargetUser) {
							// 回答の整形
							$answer = null;
							switch ($circularNoticeContent['replyType']) {
								case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT:
									$answer = $circularNoticeTargetUser['circularNoticeTargetUser']['replyTextValue'];
									break;
								case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION:
								case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION:
									$answer = implode('、', $circularNoticeTargetUser['circularNoticeTargetUser']['replySelectionValue']);
									break;
							}

							if (! $circularNoticeTargetUser['circularNoticeTargetUser']['readDatetime']) {
								$readDatetime = __d('circular_notices', 'Unread');
							} else {
								$readDatetime = $circularNoticeTargetUser['circularNoticeTargetUser']['readDatetime'];
							}

							if (! $circularNoticeTargetUser['circularNoticeTargetUser']['replyDatetime']) {
								$replyDatetime = __d('circular_notices', 'Unreply');
							} else {
								$replyDatetime = $circularNoticeTargetUser['circularNoticeTargetUser']['replyDatetime'];
							}

							echo $this->Html->tableCells(array(
								h($circularNoticeTargetUser['user']['username']),
								h($readDatetime),
								h($replyDatetime),
								h($answer),
							));
						} ?>
				</table>
				<div class="text-center">
					<?php echo $this->element('NetCommons.paginator', array(
						'url' => Hash::merge(
							array('controller' => 'circular_notices', 'action' => 'view', $frameId, $circularNoticeContent['id']),
							$this->Paginator->params['named']
						)
					)); ?>
				</div>
			</div>

			<p class="text-center">
				<span class="nc-tooltip" tooltip="<?php echo h(__d('circular_notices', 'Back')); ?>">
					<a href="<?php echo $this->Html->url('/') ?>" class="btn btn-default">
						<span class="glyphicon">戻る</span>
					</a>
				</span>
			</p>
		</div>
	</div>
</div>

