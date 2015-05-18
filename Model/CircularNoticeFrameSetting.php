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

/**
 * saveCircularNoticeFrameSetting method
 *
 * @param array $data
 * @return boolean
 */
	public function saveCircularNoticeFrameSetting($data) {
		// 必要なモデル読み込み
		$this->loadModels([
			'CircularNoticeFrameSetting' => 'CircularNotices.CircularNoticeFrameSetting',
		]);

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			//バリデーション
			if (!$this->validateCircularNoticeFrameSetting($data)) {
				return false;
			}

			//登録処理
			if (! $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$dataSource->commit();

		} catch (Exception $ex) {
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}

		return true;
	}

/**
 * validate circular_notice_frame_settings
 *
 * @param array $data received post data
 * @return bool True on success, false on error
 */
	public function validateCircularNoticeFrameSetting($data) {
		$this->set($data);
		$this->validates();
		return $this->validationErrors ? false : true;
	}

	/**
	 * getDisplayNumberOptions method
	 *
	 * @return array
	 */
	public static function getDisplayNumberOptions() {
		return array(
			1 => __d('bbses', '%s article', 1),
			5 => __d('bbses', '%s articles', 5),
			10 => __d('bbses', '%s articles', 10),
			20 => __d('bbses', '%s articles', 20),
			50 => __d('bbses', '%s articles', 50),
			100 => __d('bbses', '%s articles', 100),
		);
	}
}
