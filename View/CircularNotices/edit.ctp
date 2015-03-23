<?php
/**
 * RssReaders edit form element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Html->script('/net_commons/base/js/workflow.js', false); ?>
<?php echo $this->Html->script('/net_commons/base/js/wysiwyg.js', false); ?>
<?php echo $this->Html->css('/circularNotices/css/circular_notices.css'); ?>

<div id="nc-circular-notices-<?php echo (int)$frameId; ?>"
	 ng-controller="CircularNotices.edit"
	 ng-init="initialize(<?php echo h(json_encode($this->viewVars)); ?>)">

<?php echo $this->Form->hidden('Frame.id', array(
	'value' => $frameId
)); ?>

<?php echo $this->Form->hidden('Block.id', array(
	'value' => $blockId,
)); ?>



<?php /* <div class="row form-group">
*/ ?>
	<div class="col-xs-4">
		<?php echo $this->Form->label('CircularNoticeContent.subject',
				__d('circular_notices', 'Subject') . $this->element('NetCommons.required')
		); ?>
		<div class="input-group">
			<?php echo $this->Form->input(
					'CircularNoticeContent.subject',
					array(
						'type' => 'text',
						'label' => '',
						'error' => false,
						'class' => 'form-control',
						'value' => (isset($circularNoticeContent['title']) ? $circularNoticeContent['title'] : ''),
						'placeholder' => '',
						'div' => false,
					)
				); ?>
		</div>

		<div class="panel-body has-feedback">
			<?php echo $this->element('edit_form'); ?>
		</div>

		<?php echo $this->Form->label('CircularNoticeContent.subject',
				__d('circular_notices', 'Reply Type') . $this->element('NetCommons.required')
		); ?>

		<?php echo $this->Form->input('replyType',
			array(
				'label' => false,
				'type' => 'select',
				'ng-options' => 'type.num as type.label for type in replyType',
				'class' => 'form-control',
				'ng-model' => 'replyType',
				'ng-change' => 'selectCategory()',
				'div' => false,
			)); ?>


<?php /*
<!-- 	</div> -->
			<span class="input-group-btn">
				<button class="btn btn-default" type="button" ng-click="getSiteInfo()">
					<?php echo __d('rss_readers', 'Get Site Info'); ?>
				</button>
			</span>
		</div>
	</div>

	<div class="col-xs-12">
		<?php echo $this->element(
			'RssReaders.errors', [
				'errors' => $this->validationErrors,
				'model' => 'RssReader',
				'field' => 'url',
			]); ?>
	</div>
</div>

<?php echo $this->element('RssReaders/input_field', array(
			'model' => 'RssReader',
			'field' => 'title',
			'label' => __d('rss_readers', 'Site Title') . $this->element('NetCommons.required'),
		)
	); ?>

<?php echo $this->element('RssReaders/input_field', array(
			'model' => 'RssReader',
			'field' => 'link',
			'label' => __d('rss_readers', 'Site Url'),
			'attributes' => array(
				'placeholder' => 'http://',
			),
		)
	); ?>

<?php echo $this->element('RssReaders/input_field', array(
			'model' => 'RssReader',
			'field' => 'summary',
			'label' => __d('rss_readers', 'Site Explanation'),
			'attributes' => array(
				'type' => 'textarea',
				'rows' => 2,
			),
		)
	);
*/ ?>
</div>
