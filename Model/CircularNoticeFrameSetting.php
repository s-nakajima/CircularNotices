<?php
/**
 * CircularNoticeFrameSetting Model
 *
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CircularNoticesAppModel', 'CircularNotices.Model');

/**
 * CircularNoticeFrameSetting Model
 */
class CircularNoticeFrameSetting extends CircularNoticesAppModel {

	// 定数定義
	const DEFAULT_DISPLAY_NUMBER = 5;	// 表示件数

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'master';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'frame_key' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'display_number' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'created_user' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
//		'Block' => array(
//			'className' => 'Blocks.Block',
//			'foreignKey' => 'block_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		),
	);

/**
 * saveInitialSetting method
 *
 * @param string $frameKey frames.key
 * @return boolean
 */
	public function saveInitialSetting($frameKey) {
		// レコードを登録
		$this->create();

		// デフォルト値を設定
		$circularNoticeFrameSetting = array(
			'CircularNoticeFrameSetting' => array(
				'frame_key' => $frameKey,
				'display_number' => self::DEFAULT_DISPLAY_NUMBER,
			)
		);

		// 保存結果を返す
		return $this->save($circularNoticeFrameSetting);
	}

	/**
	 * getCircularNoticeFrameSetting method
	 *
	 * @param string $frameKey frames.key
	 * @return array
	 */
	public function getCircularNoticeFrameSetting($frameKey) {
		// 取得項目を設定
		$fields = array(
			'CircularNoticeFrameSetting.id',
			'CircularNoticeFrameSetting.frame_key',
			'CircularNoticeFrameSetting.display_number',
		);

		// 取得条件を設定（frameKey）
		$conditions = array(
			'CircularNoticeFrameSetting.frame_key' => $frameKey
		);

		// DBから取得した値を返す
		return $this->find('first', array(
			'fields' => $fields,
			'conditions' => $conditions,
		));
	}

}
