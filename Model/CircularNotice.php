<?php
/**
 * CircularNotice Model
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
 * CircularNotice Model
 */
class CircularNotice extends CircularNoticesAppModel {

	// 定数定義
	const DEFAULT_CIRCULAR_NOTICE_NAME = '回覧板';	// 回覧板名タイトル初期値
	const DEFAULT_POSTS_AUTHORITY = 0;				// 記事投稿権限初期値（0：一般権限は投稿できない）
	const DEFAULT_MAIL_NOTICE_FLAG = 1;				// メール通知フラグ初期値（1：通知する）
	const DEFAULT_MAIL_SUBJECT = '件名';				// メール件名初期値
	const DEFAULT_MAIL_BODY = 'メール本文';			// メール本文初期値

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
		'block_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'key' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'posts_authority' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'mail_notice_flag' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'mail_subject' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'mail_body' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_auto_translated' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
//		'Block' => array(
//			'className' => 'Block',
//			'foreignKey' => 'block_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		)
	);

/**
 * saveInitialSetting method
 *
 * @param int $frameId frames.id
 * @param string $frameKey frames.key
 * @return array
 * @throws InternalErrorException
 */
	public function saveInitialSetting($frameId, $frameKey)
	{
		// 必要なモデル読み込み
		$this->loadModels([
			'CircularNoticeFrameSetting' => 'CircularNotices.CircularNoticeFrameSetting',
			'Block' => 'Blocks.Block',
		]);

		// トランザクション開始
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			// ブロックの登録
			$block = $this->Block->saveByFrameId($frameId, false);

			// 回覧板フレーム設定の初期登録（frameKey）
			$circularNoticeFrameSetting = $this->CircularNoticeFrameSetting->saveInitialSetting($frameKey);
			if (!$circularNoticeFrameSetting) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			// 回覧板の初期登録（block_id）
			$circularNotice = $this->__saveInitialSetting($block['Block']['id']);
			if (! $circularNotice) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$dataSource->commit();

			$results = array(
				'Block' => $block['Block'],
				'CircularNoticeFrameSetting' => $circularNoticeFrameSetting['CircularNoticeFrameSetting'],
				'CircularNotice' => $circularNotice['CircularNotice'],
			);

			return $results;

		} catch (Exception $ex) {
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}
	}

/**
 * __saveInitialSetting method
 *
 * @param int $blockId blocks.id
 * @return boolean
 */
	private function __saveInitialSetting($blockId)
	{
		// レコードを登録
		$this->create();

		// デフォルト値を設定
		$circularNotice = array(
			'CircularNotice' => array(
				'block_id' => $blockId,
				'key' => hash('sha256', 'circular_notice_' . microtime()),
				'name' => self::DEFAULT_CIRCULAR_NOTICE_NAME,
				'posts_authority' => self::DEFAULT_POSTS_AUTHORITY,
				'mail_notice_flag' => self::DEFAULT_MAIL_NOTICE_FLAG,
				'mail_subject' => self::DEFAULT_MAIL_SUBJECT,
				'mail_body' => self::DEFAULT_MAIL_BODY,
				'is_auto_translated' => false,
				'translation_engine' => NULL,
			)
		);

		// 保存結果を返す
		return $this->save($circularNotice);
	}

/**
 * getCircularNotice method
 *
 * @param int $blockId blocks.id
 * @return array
 */
	public function getCircularNotice($blockId)
	{
		// 取得項目を設定
		$fields = array(
			'CircularNotice.id',
			'CircularNotice.key',
			'CircularNotice.name',
		);

		// 回覧板設定値を取得
		$conditions = array(
			'block_id' => $blockId,
		);

		$circularNotice = $this->find('first', array(
			'fields' => $fields,
			'recursive' => -1,
			'conditions' => $conditions,
			'order' => 'CircularNotice.id DESC',
		));

		return $circularNotice;
	}

}
