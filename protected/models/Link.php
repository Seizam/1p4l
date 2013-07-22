<?php

/**
 * This is the model class for table "link".
 *
 * The followings are the available columns in table 'link':
 * @property integer $id
 * @property integer $user_id
 * @property integer $position
 * @property integer $type
 * @property string $label
 * @property string $link
 */
class Link extends CActiveRecord {
	// Generic

	const TYPE_UNKNOWN = 0;
	// URL (facebook, website, etc...)
	const TYPE_URL = 100;
	// Professional networks
	const TYPE_URL_GITHUB = 101;
	const TYPE_URL_LINKEDIN = 102;
	const TYPE_URL_VIADEO = 103;
	// Social networks
	const TYPE_URL_TWITTER = 201;
	const TYPE_URL_FACEBOOK = 202;
	const TYPE_URL_GOOGLEPLUS = 203;
	const TYPE_URL_PINTEREST = 204;
	const TYPE_URL_TUMBLR = 205;
	// Video
	const TYPE_URL_YOUTUBE = 301;
	const TYPE_URL_VIMEO = 302;
	// Audio
	const TYPE_URL_SOUNDCLOUD = 320;
	// Photo
	const TYPE_URL_500px = 340;
	const TYPE_URL_FLICKR = 341;
	const TYPE_URL_INSTAGRAM = 342;
	// Services (skype, IM, icq...)
	const TYPE_SERVICE = 800;
	const TYPE_SERVICE_SKYPE = 801;
	// Email (a@b.c)
	const TYPE_EMAIL = 900;
	const TYPE_EMAIL_PRO = 901;
	const TYPE_EMAIL_PERSO = 902;
	// Phone (tel:+33123456789)
	const TYPE_PHONE = 910;
	const TYPE_PHONE_PRO = 911;
	const TYPE_PHONE_PERSO = 912;
	// Address (32 regent street...)
	const TYPE_ADDRESS = 920;
	const TYPE_ADDRESS_PRO = 921;
	const TYPE_ADDRESS_PERSO = 922;
	
	private $redirect = null;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Link the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public static function countByUser($user_id) {
		return self::model()->countByAttributes(array('user_id' => $user_id));
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'link';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('link', 'required'),
			array('label', 'length', 'max' => 45),
			array('link', 'length', 'max' => 1024)
		);
	}

	public function beforeValidate() {

		$linkHelper = LinkHelper::newLinkHelper($this->link);
		$this->link = $linkHelper->getLink();
		$this->type = $linkHelper->getType();
		$this->redirect = $linkHelper->getRedirect();

		if ($this->label == null) {
			$this->label = $linkHelper->getLabel();
		} else {
			$this->label = CHtml::encode($this->label);
		}

		return parent::beforeValidate();
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'position' => 'Position',
			'type' => 'Type',
			'label' => 'Label',
			'link' => 'Link',
		);
	}

	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	protected function beforeSave() {
		if (parent::beforeSave()) {
			// On create() with empty position, position the link as last
			if ($this->isNewRecord && $this->position == null) {
				$this->position = self::countByUser($this->user_id);
			}
			return true;
		} else {
			return false;
		}
	}

	/**
	 * We need to decrement the position of all the following links
	 * afterDelete() cannot be used here because it is always executed (even if no row was affected)
	 */
	public function delete() {
		if (parent::delete()) {
			$sql = "UPDATE {$this->tableName()} SET position = position - 1 WHERE user_id = {$this->user_id} AND position > {$this->position}";
			$result = Yii::app()->db->createCommand($sql)->execute();
		}
	}

	/**
	 * Moves the current record up in the link list.
	 * This method updates the current record, and the record of the above link.
	 * @return boolean True on succes, false on fail.
	 */
	public function moveUp() {

		$ok = $this->position != null && $this->position > 0;

		if ($ok) {
			// Move above records down
			$ok = self::model()->updateAll(
					array('position' => $this->position), 'position=:position AND user_id=:uid', array(':position' => $this->position - 1, ':uid' => $this->user_id));
			$ok = ($ok === 1);
		}

		if ($ok) {
			// Move current record up
			$this->position--;
			$ok = $this->save();
		}

		return $ok;
	}

	public function isUrl() {
		return $this->type >= self::TYPE_URL && $this->type < self::TYPE_SERVICE;
	}

	public function isService() {
		return $this->type >= self::TYPE_SERVICE && $this->type < self::TYPE_EMAIL;
	}

	public function isEmail() {
		return $this->type >= self::TYPE_EMAIL && $this->type < self::TYPE_PHONE;
	}

	public function isPhone() {
		return $this->type >= self::TYPE_PHONE && $this->type < self::TYPE_ADDRESS;
	}

	public function isAddress() {
		return $this->type >= self::TYPE_ADDRESS;
	}
	
	public function getRedirect() {
		return $this->redirect;
	}

}