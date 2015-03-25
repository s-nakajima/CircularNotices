<?php
/**
 * announcements edit form element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="form-group">
	<label class="control-label">
		<?php echo __d('circular_notices', 'Content'); ?>
	</label>
	<?php echo $this->element('NetCommons.required'); ?>

	<div class="nc-wysiwyg-alert">
		<?php echo $this->Form->textarea(
			'content', [
				'class' => 'form-control',
				'ui-tinymce' => 'tinymce.options',
				'ng-model' => 'circularNoticeContentContent',
				'rows' => 5,
				'required' => 'required',
			]) ?>
	</div>

	<?php echo $this->element(
		'NetCommons.errors', [
			'errors' => $this->validationErrors,
			'model' => 'CircularNoticeContent',
			'field' => 'content',
		]) ?>
</div>

