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

<div class="form-group">
	<?php echo $this->Form->label('CircularNoticeContent.subject',
		__d('circular_notices', 'Subject') . $this->element('NetCommons.required')
	); ?>
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
