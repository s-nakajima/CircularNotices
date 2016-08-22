<?php
/**
 * CircularNotice Helper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Yuto Kitatsuji <kitatsuji.yuto@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
App::uses('AppHelper', 'View/Helper');

/**
 * CircularNotice Helper
 *
 * @author Yuto Kitatsuji <kitatsuji.yuto@withone.co.jp>
 * @package NetCommons\CircularNotices\View\Helper
 */
class CircularNoticeContentHelper extends AppHelper {

/**
 * Other helpers used by FormHelper
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Date',
		'NetCommons.NetCommonsTime',
	);

/**
 * 表示する回覧期間及び回覧期限作成
 *
 * @param string $date 回覧期間又は回覧期限
 * @return string HTML
 */
	public function displayDate($date) {
			$format = '';
			$now = $this->NetCommonsTime->getNowDatetime();
			$nowUserDatetime = $this->NetCommonsTime->toUserDatetime($now);
			$dateYear = date('Y', strtotime($date));
			$nowYear = date('Y', strtotime($nowUserDatetime));
			if ($dateYear === $nowYear) {
				$format = 'm/d';
			}

			$displayDate = $this->Date->dateFormat($date, $format);

		return $displayDate;
	}
}
