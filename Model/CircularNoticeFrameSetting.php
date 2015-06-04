<?php
/**
 * CircularNoticeFrameSetting Model
 *
 * @property Frame $Frame
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
 *
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @package NetCommons\CircularNotices\Model
 */
class CircularNoticeFrameSetting extends CircularNoticesAppModel {

/**
 * Default display number
 *
 * @var int
 */
	const DEFAULT_DISPLAY_NUMBER = 5;

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
	public $actsAs = array();

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Frame' => array(
			'className' => 'Frames.Frame',
			'foreignKey' => 'frame_key',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

/**
 * Prepare circular notice frame settings
 *
 * @param int $frameId
 * @return mixed
 * @throws Exception
 * @throws InternalErrorException
 */
	public function prepareCircularNoticeFrameSetting($frameId) {

		$this->loadModels([
			'Frame' => 'Frames.Frame',
		]);

		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {

			// フレームを取得
			if (! $frame = $this->Frame->findById($frameId)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			// フレームと紐づくフレーム設定が取得できない場合は新規作成
			if (! $circularNoticeFrameSetting = $this->findByFrameKey($frame['Frame']['key'])) {
				$data = $this->create(
					array(
						'frame_key' => $frame['Frame']['key'],
						'display_number' => self::DEFAULT_DISPLAY_NUMBER,
					)
				);
				if (! $circularNoticeFrameSetting = $this->save($data, false)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
			}

			$dataSource->commit();

		} catch (Exception $ex) {
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}

		return $circularNoticeFrameSetting;
	}

/**
 * Get circular notice frame settings
 *
 * @param string $frameKey
 * @return mixed
 */
	public function getCircularNoticeFrameSetting($frameKey) {
		return $this->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'frame_key' => $frameKey,
			),
		));
	}

/**
 * Save circular notice frame settings
 *
 * @param array $data
 * @return bool
 * @throws Exception
 * @throws InternalErrorException
 */
	public function saveCircularNoticeFrameSetting($data) {

		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {

			if (! $this->validateCircularNoticeFrameSetting($data)) {
				return false;
			}

			if (! $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$dataSource->commit();

		} catch (Exception $ex) {
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}

		return true;
	}

/**
 * Validate this model
 *
 * @param array $data
 * @return bool
 */
	public function validateCircularNoticeFrameSetting($data) {
		$this->set($data);
		$this->validates();
		return $this->validationErrors ? false : true;
	}

/**
 * Get display numbers for limit options
 *
 * @return array
 */
	public static function getDisplayNumberOptions() {
		return array(
			1 => __d('circular_notices', '%d items', 1),
			5 => __d('circular_notices', '%d items', 5),
			10 => __d('circular_notices', '%d items', 10),
			20 => __d('circular_notices', '%d items', 20),
			50 => __d('circular_notices', '%d items', 50),
			100 => __d('circular_notices', '%d items', 100),
		);
	}
}
