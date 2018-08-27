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
 * Called during validation operations, before validation. Please note that custom
 * validation rules can be defined in $validate.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforevalidate
 * @see Model::save()
 */
	public function beforeValidate($options = array()) {
		$this->validate = array_merge($this->validate, array(
			'value' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'weight' => array(
				'naturalNumber' => array(
					'rule' => array('naturalNumber', true),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
		));
		return parent::beforeValidate($options);
	}

/**
 * Use behaviors
 *
 * @var array
 */
	public $actAs = array();

/**
 * Delete-insert circular notice choices
 *
 * @param array $data input data
 * @return bool
 * @throws InternalErrorException
 */
	public function replaceCircularNoticeChoices($data) {
		$contentId = $data['CircularNoticeContent']['id'];

		// 1件ずつ保存
		foreach ($data['CircularNoticeChoices'] as $choice) {
			unset($choice['CircularNoticeChoice']['id']);	// 常に新規登録
			$choice['CircularNoticeChoice']['circular_notice_content_id'] = $contentId;
			$this->create($choice);
			if (! $this->validateCircularChoice($choice)) {
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
 * @param array $data input data
 * @return bool
 */
	public function validateCircularChoice($data) {
		$this->set($data);
		$this->validates();
		return $this->validationErrors ? false : true;
	}

/**
 * Validate this models
 *
 * @param array $data input data
 * @return bool
 */
	public function validateCircularChoices($data) {
		if (isset($data['CircularNoticeChoices'])) {
			foreach ($data['CircularNoticeChoices'] as $value) {
				if (!$this->validateCircularChoice($value)) {
					return false;
				}
			}
		}
		return true;
	}
}

