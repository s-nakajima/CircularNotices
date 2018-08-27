<?php
/**
 * CircularNoticeSettings Model
 *
 * @property Block $Block
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CircularNoticesAppModel', 'CircularNotices.Model');

/**
 * CircularNoticeSetting Model
 *
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @package NetCommons\CircularNotices\Model
 */
class CircularNoticeSetting extends CircularNoticesAppModel {

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
		$this->validate = array_merge($this->validate, []);
		return parent::beforeValidate($options);
	}

/**
 * Use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.OriginalKey',
		'Blocks.BlockRolePermission',
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Block' => array(
			'className' => 'Blocks.block',
			'foreignKey' => 'block_key',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * Set circular notice settings
 *
 * @param int $frameId frames.id
 * @return mixed
 * @throws InternalErrorException
 */
	public function setCircularNoticeSetting($frameId) {
		$this->loadModels([
			'Frame' => 'Frames.Frame',
			'Block' => 'Blocks.Block',
		]);

		$this->begin();

		try {

			// フレームを取得
			if (! $frame = $this->Frame->findById($frameId)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			if (! isset($frame['Frame']['block_id'])) {
				// フレームとブロックが紐付いていない
				// フレームと同じルームに紐付いている回覧板ブロックを取得
				if (! $block = $this->getLinkedBlockByFrame($frame)) {
					return false;
				}
				Current::$current['Block'] = $block['Block'];
				// 存在する場合はフレームと紐付け
				$frame['Frame']['block_id'] = $block['Block']['id'];
				if (! $this->Frame->save($frame, false)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
			} else {
				// 紐付いていればそのブロックを取得
				$block = $this->Block->findById($frame['Frame']['block_id']);
			}

			// ブロックに紐づく設定が存在しなければ新規作成
			if (! $blockSetting = $this->findByBlockKey($block['Block']['key'])) {
				$data = $this->create(array(
					'block_key' => $block['Block']['key'],
				));
				if (! $blockSetting = $this->save($data, false)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
			}

			$this->commit();

		} catch (Exception $ex) {
			$this->rollback();
			CakeLog::error($ex);
			throw $ex;
		}

		return $blockSetting;
	}

/**
 * get block
 *
 * @param mixed $frame frames
 * @return mixed
 */
	public function getLinkedBlockByFrame($frame) {
		$this->loadModels([
			'Frame' => 'Frames.Frame',
			'Block' => 'Blocks.Block',
		]);

		$block = $this->Block->find('first', array(
			'conditions' => array(
				'Block.room_id' => $frame['Frame']['room_id'],
				'Block.plugin_key' => 'circular_notices',
			)
		));

		if (! $block) {
			// フレームと同じルームに紐付く回覧板ブロックが存在しなければ新規作成してフレームと紐付け
			//$block = $this->Block->create(array(
			//	'language_id' => $frame['Frame']['language_id'],
			//	'room_id' => $frame['Frame']['room_id'] ? $frame['Frame']['room_id'] : 0,
			//	'plugin_key' => 'circular_notices',
			//));
			//$block = $this->Block->saveByFrameId($frameId, $block);]
			if ($frame['Frame']['room_id']) {
				$roomId = $frame['Frame']['room_id'];
			} else {
				$roomId = 0;
			}
			$block = $this->Block->save(array(
				'room_id' => $roomId,
				'plugin_key' => $frame['Frame']['plugin_key'],
			));
			//if (!$block) {
			//	return false;
			//}
		}
		return $block;
	}
/**
 * Get circular notice settings
 *
 * @param int $frameId frames.id
 * @return mixed
 */
	public function getCircularNoticeSetting($frameId) {
		$this->loadModels([
			'Frame' => 'Frames.Frame',
		]);

		if (! $frame = $this->Frame->findById($frameId)) {
			return null;
		}

		return $this->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'block_key' => $frame['Block']['key'],
			),
		));
	}

/**
 * Save circular notice settings
 *
 * @param array $data input data
 * @return bool
 * @throws InternalErrorException
 */
	public function saveCircularNoticeSetting($data) {
		$this->loadModels([
			'BlockRolePermission' => 'Blocks.BlockRolePermission',
		]);

		$this->begin();

		// バリデーション
		$this->set($data);
		if (! $this->validates()) {
			$this->rollback();
			return false;
		}

		try {
			if (! $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			$this->commit();

		} catch (Exception $ex) {
			$this->rollback();
			CakeLog::error($ex);
			throw $ex;
		}

		return true;
	}
}
