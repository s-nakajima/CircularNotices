<?php
/**
 * CircularNoticeChoice Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CircularNoticesAppModel', 'CircularNotices.Model');

/**
 * CircularNoticeChoice Model
 *
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @package NetCommons\CircularNotices\Model
 */
class CircularNoticeChoice extends CircularNoticesAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * Use behaviors
 *
 * @var array
 */
	public $actAs = array();

/**
 * Delete-insert circular notice choices
 *
 * @param array $data
 */
	public function replaceCircularNoticeChoices($data) {

		$contentId = $data['CircularNoticeContent']['id'];

		// 残す選択肢の条件を生成
		$deleteConditions = array(
			'CircularNoticeChoice.circular_notice_content_id' => $contentId,
		);
		$extractIds = Hash::filter(Hash::extract($data['CircularNoticeChoices'], '{n}.CircularNoticeChoice.id'));
		if (count($extractIds) > 0) {
			$deleteConditions['CircularNoticeChoice.id NOT'] = $extractIds;
		}

		// 選択肢を一旦削除
		if (! $this->deleteAll($deleteConditions, false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		// 1件ずつ保存
		foreach ($data['CircularNoticeChoices'] as $choice) {

			$choice['CircularNoticeChoice']['circular_notice_content_id'] = $contentId;

			if (! $this->__validateCircularChoice($choice)) {
				return false;
			}

			if (! $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		return true;
	}

/**
 * Validate this model
 *
 * @param array $data
 * @return bool
 */
	private function __validateCircularChoice($data) {
		$this->set($data);
		$this->validates();
		return $this->validationErrors ? false : true;
	}
}
