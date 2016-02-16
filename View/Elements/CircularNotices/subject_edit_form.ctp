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
	<?php
		echo $this->NetCommonsForm->input(
			'CircularNoticeContent.subject',
			array(
				'label' => __d('circular_notices', 'Subject'),
				'required' => 'required',
				'ng-model' => 'circularNoticeContent.subject',
			)
		);
	?>
</div>
