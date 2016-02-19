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

<div id="nc-circular-notices-<?php echo (int)Current::read('Frame.id'); ?>" ng-controller="CircularNoticeView" ng-init="initialize()">

	<div class="circular-notice-index-status-label">
		<?php echo $this->element('CircularNotices/status_label', array('circularNoticeContent' => array('circularNoticeContent' => $circularNoticeContent))); ?>
	</div>

	<!-- 編集 -->
	<?php if (Current::permission('content_creatable') && $circularNoticeContent['createdUser'] == $userId) : ?>
		<div class="pull-right">
			<span class="nc-tooltip" tooltip="<?php echo h(__d('net_commons', 'Edit')); ?>">
				<?php echo $this->NetCommonsHtml->link(
					'<span class="glyphicon glyphicon-edit"> </span>',
					$this->NetCommonsHtml->url(
						array(
							'controller' => 'circular_notices',
							'action' => 'edit',
							'key' => $circularNoticeContent['key']
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

	<h1>
		<?php echo h($circularNoticeContent['subject']); ?>
	</h1>

	<div class="clearfix">
		<div class="pull-left">
			<?php echo h(__d('circular_notices', 'Circular Content Period Title')); ?>
			<?php echo $this->Date->dateFormat($circularNoticeContent['openedPeriodFrom']); ?>
			～
			<?php echo $this->Date->dateFormat($circularNoticeContent['openedPeriodTo']); ?><br />
			<?php echo h(__d('circular_notices', 'Created User Title')); ?>
			<?php echo h($user['username']); ?><br />
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

	<hr />

	<div>
		<?php echo h(__d('circular_notices', 'Reply Type Title')); ?>
		<?php
		switch ($circularNoticeContent['replyType']) {
			case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT:
				echo h(__d('circular_notices', 'Reply Type Text'));
				break;
			case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION:
				echo h(__d('circular_notices', 'Reply Type Selection'));
				break;
			case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION:
				echo h(__d('circular_notices', 'Reply Type Multiple Selection'));
				break;
		}
		?>
	</div>

	<?php if ($circularNoticeContent['replyType'] != CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT) : ?>
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
		$circularNoticeContent['currentStatus'] == CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_STATUS_OPEN &&
		isset($myAnswer['circularNoticeTargetUser']['userStatus'])
	) : ?>

		<hr />

		<div>

<!--			--><?php //echo h(__d('circular_notices', 'Answer Title')); ?>
			<?php
			switch ($circularNoticeContent['replyType']) {
				case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT:
					echo h($myAnswer['circularNoticeTargetUser']['originReplyTextValue']);
					break;
				case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION:
				case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION:
					$selectionValues = explode(CircularNoticeComponent::SELECTION_VALUES_DELIMITER, $myAnswer['circularNoticeTargetUser']['originReplySelectionValue']);
					echo h(implode('、', $selectionValues));
					break;
			}
			?>

			<hr class="circular-notice-spacer" />

			<?php echo $this->NetCommonsForm->create('CircularNoticeTargetUser', array(
				'name' => 'form',
				'novalidate' => true,
			)); ?>
			<?php echo $this->NetCommonsForm->hidden('CircularNoticeContent.key', array(
				'value' => $circularNoticeContent['key'],
			)); ?>

				<div ng-hide="showReplyForm==false">
					回答：
				</div>
				<div class="panel panel-default" ng-hide="showReplyForm==false">
					<div class="panel-body">
						<div class="form-group">

						<?php echo $this->Form->hidden('CircularNoticeTargetUser.id', array(
							'value' => $myAnswer['circularNoticeTargetUser']['id'],
						)); ?>

						<?php
						switch ($circularNoticeContent['replyType']) {
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
								foreach ($circularNoticeChoice as $choice) :
									$selections[$choice['value']] = $choice['value'];
								endforeach;
								echo $this->Form->input('CircularNoticeTargetUser.reply_selection_value', array(
									'div' => false,
									'type' => 'radio',
									'legend' => false,
									'label' => true,
									'value' => $myAnswer['circularNoticeTargetUser']['replySelectionValue'],
									'options' => $selections,
									'separator' => '<br />',
								));
								break;
							case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION:
								$selections = array();
								foreach ($circularNoticeChoice as $choices) :
									$selections[$choices['value']] = $choices['value'];
								endforeach;
								$selected = explode(CircularNoticeComponent::SELECTION_VALUES_DELIMITER, $myAnswer['circularNoticeTargetUser']['replySelectionValue']);
								echo $this->Form->input('CircularNoticeTargetUser.reply_selection_value', array(
									'div' => false,
									'type' => 'select',
									'legend' => true,
									'label' => false,
									'multiple' => 'checkbox',
									'selected' => $selected,
									'options' => $selections,
								));
								break;
						}
						?>

						</div>
					</div>
				</div>

				<div class="text-center">
					<?php if (! $myAnswer['circularNoticeTargetUser']['replyFlag']) : ?>
						<span class="nc-tooltip" tooltip="<?php echo h(__d('circular_notices', 'Do Answer')); ?>">
							<button type="button" class="btn btn-success"
								ng-click="switchReplyForm(true);"
								ng-hide="showReplyForm!=false"
								ng-disabled="sending">
								<span class="glyphicon glyphicon-plus"></span>
								<?php echo h(__d('circular_notices', 'Answer')); ?>
							</button>
						</span>
					<?php else : ?>
						<span class="nc-tooltip" tooltip="<?php echo h(__d('circular_notices', 'Change Answer')); ?>">
							<button type="button" class="btn btn-primary"
								ng-click="switchReplyForm(true);"
								ng-hide="showReplyForm!=false"
								ng-disabled="sending">
								<span class="glyphicon glyphicon-edit"></span>
								<?php echo h(__d('circular_notices', 'Change Answer')); ?>
							</button>
						</span>
					<?php endif; ?>

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
				</div>

			<?php echo $this->Form->end(); ?>

		</div>

<!--		<div>-->
<!--			--><?php //echo $this->element(
//				'NetCommons.errors', [
//					'errors' => $this->validationErrors,
//					'model' => 'CircularNoticeTargetUser',
//					'field' => 'reply_text_value',
//				]); ?>
<!--		</div>-->

	<?php endif; ?>

	<hr />

	<div class="text-center">

		<span class="nc-tooltip" tooltip="<?php echo h(__d('circular_notices', 'Show Other Users')); ?>">
			<button type="button" class="btn btn-default"
				ng-click="switchOtherUserView(true)"
				ng-hide="showOtherUsers!=false">
				<span class="glyphicon glyphicon-plus"></span>
				<?php echo h(__d('circular_notices', 'Show Other Users')); ?>
			</button>
		</span>

		<span class="nc-tooltip" tooltip="<?php echo h(__d('circular_notices', 'Close Other Users')); ?>">
			<button type="button" class="btn btn-default"
				ng-click="switchOtherUserView(false)"
				ng-hide="showOtherUsers!=true">
				<span class="glyphicon glyphicon-minus"></span>
				<?php echo h(__d('circular_notices', 'Close Other Users')); ?>
			</button>
		</span>

	</div>

	<hr class="circular-notice-spacer" />

	<div ng-hide="showOtherUsers!=true">

		<div class="clearfix">
			<div class="pull-left">
				<?php echo $this->element('CircularNotices/view_select_sort'); ?>
				<?php echo $this->element('CircularNotices/view_select_limit'); ?>
			</div>
			<div class="pull-right">
				<span class="nc-tooltip" tooltip="<?php echo h(__d('circular_notices', 'Download')); ?>">
					<button type="button" class="btn btn-default"
						ng-click="switchOtherUserView(true)">
						<span class="glyphicon glyphicon-download"> </span>
					</button>
				</span>
			</div>
		</div>

		<hr class="circular-notice-spacer" />

		<table class="table table-bordered">
			<?php
				echo $this->Html->tableHeaders(
					array(
						h(__d('circular_notices', 'Target User')),
						h(__d('circular_notices', 'Read Datetime')),
						h(__d('circular_notices', 'Reply Datetime')),
						h(__d('circular_notices', 'Answer')),
					),
					array('class' => 'active')
				);

				foreach ($circularNoticeTargetUsers as $circularNoticeTargetUser) :
					$answer = null;
					switch ($circularNoticeContent['replyType']) {
						case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_TEXT:
							$answer = $circularNoticeTargetUser['circularNoticeTargetUser']['replyTextValue'];
							break;
						case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_SELECTION:
						case CircularNoticeComponent::CIRCULAR_NOTICE_CONTENT_REPLY_TYPE_MULTIPLE_SELECTION:
							$selectionValues = explode(CircularNoticeComponent::SELECTION_VALUES_DELIMITER, $circularNoticeTargetUser['circularNoticeTargetUser']['replySelectionValue']);
							$answer = implode('、', $selectionValues);
							break;
					}

					if (! $circularNoticeTargetUser['circularNoticeTargetUser']['readDatetime']) :
						$readDatetime = __d('circular_notices', 'Unread');
					else :
						$readDatetime = $this->Date->dateFormat($circularNoticeTargetUser['circularNoticeTargetUser']['readDatetime']);
					endif;

					if (! $circularNoticeTargetUser['circularNoticeTargetUser']['replyDatetime']) :
						$replyDatetime = __d('circular_notices', 'Unreply');
					else :
						$replyDatetime = $this->Date->dateFormat($circularNoticeTargetUser['circularNoticeTargetUser']['replyDatetime']);
					endif;

					echo $this->Html->tableCells(array(
//						h($circularNoticeTargetUser['user']['username']),
						h($circularNoticeTargetUser['user']['handlename']),
						h($readDatetime),
						h($replyDatetime),
						h($answer),
					));
				endforeach;
			?>
		</table>

		<div class="text-center">
			<?php echo $this->element('NetCommons.paginator', array(
				'url' => Hash::merge(
//					array('controller' => 'circular_notices', 'action' => 'view', $frameId, $circularNoticeContent['id']),
					array('controller' => 'circular_notices', 'action' => 'view', Current::read('Frame.id'), $circularNoticeContent['id']),
					$this->Paginator->params['named']
				)
			)); ?>
		</div>
	</div>

	<div class="text-center">
		<span class="nc-tooltip" tooltip="<?php echo h(__d('circular_notices', 'Back')); ?>">
<!--			<a href="--><?php //echo $this->Html->url('/') ?><!--" class="btn btn-default">-->
<!--				<span class="glyphicon">--><?php //echo h(__d('circular_notices', 'Back')); ?><!--</span>-->
<!--			</a>-->
			<?php echo $this->NetCommonsHtml->link(
				'<span class="glyphicon">' . __d('circular_notices', 'Back') . '</span>',
				$this->NetCommonsHtml->url(
					array(
						'controller' => 'circular_notices',
						'action' => 'index',
					)
				),
				array(
					'class' => 'btn btn-default',
					'escape' => false
				)
			);
			?>
		</span>
	</div>

</div>
