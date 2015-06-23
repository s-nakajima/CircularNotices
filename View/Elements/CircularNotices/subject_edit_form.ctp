<?php
/**
 * circular notice edit subject element
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
			'CircularNoticeContent.subject',
			__d('circular_notices', 'Subject') . $this->element('NetCommons.required')
		); ?>
	</div>
	<div>
		<?php echo $this->Form->input(
			'CircularNoticeContent.subject',
			array(
				'type' => 'text',
				'label' => '',
				'error' => false,
				'class' => 'form-control',
				'value' => (isset($circularNoticeContent['subject']) ? $circularNoticeContent['subject'] : ''),
				'placeholder' => '',
				'div' => false,
			)
		); ?>
	</div>
	<div>
		<?php echo $this->element(
			'NetCommons.errors', [
				'errors' => $this->validationErrors,
				'model' => 'CircularNoticeContent',
				'field' => 'subject',
			]); ?>
	</div>
</div>
