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
		<?php echo __d('circular_notices', 'Plugin Name'); ?>
	</div>

	<div class="panel panel-default">
		<div class="panel-body">
			<div class="circular-notice-index-content">
				<?php echo $circularNoticeContent['subject']; ?><br />
				<div class="circular-notice-indent">
					<?php echo __d('circular_notices', 'Circular Content Period Title'); ?>
					<?php echo date("Y/m/d H:i", strtotime($circularNoticeContent['openedPeriodFrom'])); ?>
					～
					<?php echo date("Y/m/d H:i", strtotime($circularNoticeContent['openedPeriodTo'])); ?><br />
					<?php echo __d('circular_notices', 'Created User Title'); ?>
					<?php echo $circularNoticeContent['createdUsername']; ?><br />
				</div>
			</div>
			<div class="circular-notice-index-counter">
				<?php echo __d('circular_notices', 'Read Count Title'); ?> <?php echo $circularNoticeContent['circularNoticeReadCount']; ?>
				/
				<?php echo $circularNoticeContent['circularNoticeTargetCount']; ?><br />
				<?php echo __d('circular_notices', 'Reply Count Title'); ?> <?php echo $circularNoticeContent['circularNoticeReplyCount']; ?>
				/
				<?php echo $circularNoticeContent['circularNoticeTargetCount']; ?>
			</div>
			<hr class="circular-notice-clear-float">
			<div>
				<?php echo $circularNoticeContent['content']; ?>
			</div>
			<hr class="circular-notice-clear-float">
			<div>
				<?php echo __d('circular_notices', 'Reply Type Title'); ?>
				<?php switch($circularNoticeContent['replyType']) {
						case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT:
							echo __d('circular_notices', 'Reply Type Text');
							break;
						case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION:
							echo __d('circular_notices', 'Reply Type Selection');
							break;
						case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION:
							echo __d('circular_notices', 'Reply Type Multiple Selection');
							break;
					}?>
			</div>
			<?php if ($circularNoticeContent['replyType'] != CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT) { ?>
				<div class="circular-notice-box-left">
					<?php echo __d('circular_notices', 'Choices Title'); ?>
				</div>
				<div class="circular-notice-box-left">
					<?php foreach ($circularNoticeChoices as $circularNoticeChoice) { ?>
						<?php echo $circularNoticeChoice['circularNoticeChoice']['value']; ?>
						<br />
					<?php } ?>
				</div>
				<div>
					<?php foreach ($circularNoticeChoices as $circularNoticeChoice) { ?>
						<?php echo __d('circular_notices', 'Selected Count', $circularNoticeChoice['circularNoticeChoice']['selectedCount']); ?>
						<br />
					<?php } ?>
				</div>
			<?php } ?>
			<hr class="circular-notice-clear-float">
			<?php if ($circularNoticeContent['replyDeadlineSetFlag'] == false ||
					 ($circularNoticeContent['replyDeadlineSetFlag'] == true && $circularNoticeContent['replyDeadline'] > date("Y-m-d H:i:s", time()))) { ?>
				<?php echo $this->Form->create('CircularNoticeTargetUser', array(
						'name' => 'form',
						'novalidate' => true,
					)); ?>
			<?php } ?>
			<div>
				<?php echo __d('circular_notices', 'Answer Title'); ?>
				<?php switch ($circularNoticeContent['replyType']) {
					case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT:
					case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION:
						echo $circularNoticeContent['answer'];
						break;
					case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION:
						$answers = '';
						foreach ($circularNoticeContent['answer'] as $ans) {
							$answers .= $ans . ',';
						}
						echo substr($answers, 0, -1);
						break;
				} ?>

				<?php if ($circularNoticeContent['replyDeadlineSetFlag'] == false ||
						 ($circularNoticeContent['replyDeadlineSetFlag'] == true && $circularNoticeContent['replyDeadline'] > date("Y-m-d H:i:s", time()))) { ?>
					<div class="circular-notice-block" ng-hide="showReplyForm==false">
						<div class="form-inline">
							<?php echo $this->Form->hidden('CircularNoticeTargetUser.circular_notice_content_id', array(
								'value' => $circularNoticeContent['id'],
							)); ?>
							<?php echo $this->Form->hidden('CircularNoticeTargetUser.circular_notice_content_id', array(
								'value' => $circularNoticeContent['id'],
							)); ?>
							<?php echo $this->Form->hidden('CircularNoticeTargetUser.id', array(
								'value' => $circularNoticeContent['id'],
							)); ?>

							<?php switch ($circularNoticeContent['replyType']) {
									case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT:
										echo $this->Form->input('CircularNoticeTargetUser.reply_text_value',
											array(
												'type' => 'text',
												'label' => '',
												'error' => false,
												'class' => 'form-control',
												'value' => $circularNoticeContent['answer'],
												'placeholder' => '',
												'div' => true,
											));
										break;
									case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION:
										$selections = null;
										foreach ($circularNoticeChoices as $circularNoticeChoice) {
											$selections[$circularNoticeChoice['circularNoticeChoice']['value']] = $circularNoticeChoice['circularNoticeChoice']['value'];
										}
										echo $this->Form->input('CircularNoticeTargetUser.reply_selection_value',
											array(
												'class' => 'form-control',
												'type' => 'radio',
												'div' => true,
												'legend' => false,
												'selected' => $circularNoticeContent['answer'],
												'ng-model' => 'answer',
												'options' => $selections,
											));
										break;
									case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION:
										$selections = null;
										foreach ($circularNoticeChoices as $circularNoticeChoice) {
											$selections[$circularNoticeChoice['circularNoticeChoice']['value']] = $circularNoticeChoice['circularNoticeChoice']['value'];
										}
										echo $this->Form->input('CircularNoticeTargetUser.reply_selection_value',
											array(
												'class' => 'circular-notice-checkbox',
												'div' => false,
												'type' => 'select',
												'label' => false,
												'multiple' => 'checkbox',
												'selected' => $circularNoticeContent['answer'],
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
					<?php if (! $circularNoticeContent['answer']) { ?>
						<span class="nc-tooltip" tooltip="<?php echo __d('circular_notices', 'Do Answer'); ?>">
							<button type="button" class="btn btn-success"
								ng-click="switchReplyForm(true);"
								ng-hide="showReplyForm!=false"
								ng-disabled="sending">
								<span class="glyphicon glyphicon-plus"></span>
								<?php echo __d('circular_notices', 'Answer'); ?>
							</button>
						</span>
					<?php } else { ?>
						<span class="nc-tooltip" tooltip="<?php echo __d('circular_notices', 'Change Answer'); ?>">
							<button type="button" class="btn btn-primary"
								ng-click="switchReplyForm(true);"
								ng-hide="showReplyForm!=false"
								ng-disabled="sending">
								<span class="glyphicon glyphicon-edit"></span>
								<?php echo __d('circular_notices', 'Change Answer'); ?>
							</button>
						</span>
					<?php } ?>

					<button type="button" class="btn btn-default"
						ng-click="switchReplyForm(false);"
						ng-hide="showReplyForm!=true"
						ng-disabled="sending">
						<span class="glyphicon glyphicon-remove"></span>
						<?php echo __d('net_commons', 'Cancel'); ?>
					</button>

					<button type="submit" class="btn btn-primary"
						ng-click="this.form.submit();"
						ng-hide="showReplyForm!=true"
						ng-disabled="sending">
						<span class="glyphicon glyphicon-remove"></span>
						<?php echo __d('net_commons', 'OK'); ?>
					</button>
				</p>
				<?php echo $this->Form->end(); ?>
			<?php } ?>
			<hr />
			<div class="circular-notice-block text-center" ng-hide="showOtherUsers!=false" ng-click="switchOtherUserView(true)">
				<?php echo __d('circular_notices', 'Show Other Users'); ?>
			</div>
			<div class="circular-notice-block text-center" ng-hide="showOtherUsers!=true" ng-click="switchOtherUserView(false)">
				<?php echo __d('circular_notices', 'Close Other Users'); ?>
			</div>
			<table class="table table-bordered" ng-hide="showOtherUsers!=true">
				<?php echo $this->Html->tableHeaders(
						array(
							__d('circular_notices', 'Target User'),
							__d('circular_notices', 'Read Datetime'),
							__d('circular_notices', 'Reply Datetime'),
							__d('circular_notices', 'Answer'),
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
								$answer = $circularNoticeTargetUser['circularNoticeTargetUser']['replySelectionValue'];
								break;
							case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION:
								$answers = explode(",", $circularNoticeTargetUser['circularNoticeTargetUser']['replySelectionValue']);
								foreach ($answers as $ans) {
									$answer .= $ans . ',';
								}
								$answer = substr($answer, 0, -1);
								break;
						}

						if (! $circularNoticeTargetUser['circularNoticeTargetUser']['readDatetime']) {
							$readDatetime = __d('circular_notices', 'Unread');
						} else {
							$readDatetime = date("Y/m/d H:i", strtotime($circularNoticeTargetUser['circularNoticeTargetUser']['readDatetime']));
						}

						if (! $circularNoticeTargetUser['circularNoticeTargetUser']['replyDatetime']) {
							$replyDatetime = __d('circular_notices', 'Unreply');
						} else {
							$replyDatetime = date("Y/m/d H:i", strtotime($circularNoticeTargetUser['circularNoticeTargetUser']['replyDatetime']));
						}

						echo $this->Html->tableCells(
							array(
								$circularNoticeTargetUser['user']['username'],
								$readDatetime,
								$replyDatetime,
								$answer,
						));
					} ?>
			</table>
			<p class="text-center">
				<span class="nc-tooltip" tooltip="<?php echo __d('circular_notices', 'Back'); ?>">
					<a href="<?php echo $this->Html->url('/') ?>" class="btn btn-default">
						<span class="glyphicon">戻る</span>
					</a>
				</span>
			</p>
		</div>
	</div>
</div>

