<?php
/**
 * circular notice select limit for index element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$url = NetCommonsUrl::actionUrlAsArray(Hash::merge(array(
	'plugin' => 'circular_notices',
	'controller' => 'circular_notices',
	'action' => 'index',
	'frame_id' => Current::read('Frame.id'),
), $this->Paginator->params['named']));

$options = CircularNoticeFrameSetting::getDisplayNumberOptions();
$currentLimit = $this->Paginator->param('limit') ? $this->Paginator->param('limit') : CircularNoticeFrameSetting::DEFAULT_DISPLAY_NUMBER;

echo $this->DisplayNumber->dropDownToggle(array(
	'url' => $url,
	'currentLimit' => $currentLimit,
	'options' => $options,
));