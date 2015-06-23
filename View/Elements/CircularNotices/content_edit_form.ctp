<?php
/**
 * circular notice edit content element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="form-group">
	<div>
		<?php echo $this->Form->label(
			'CircularNoticeContent.content',
			__d('circular_notices', 'Content') . $this->element('NetCommons.required')
		); ?>
	</div>
	<div>
		<?php echo $this->Form->textarea(
			'CircularNoticeContent.content', [
				'label' => false,
				'class' => 'form-control',
				'ui-tinymce' => 'tinymce.options',
				'ng-model' => 'circularNoticeContent.content',
				'rows' => 5,
				'required' => 'required',
			]) ?>
	</div>
	<div>
		<?php echo $this->element(
			'NetCommons.errors', [
				'errors' => $this->validationErrors,
				'model' => 'CircularNoticeContent',
				'field' => 'content',
			]) ?>
	</div>
</div>

