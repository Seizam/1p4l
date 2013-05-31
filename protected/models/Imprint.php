<?php

/**
 * This is the model class for table "imprint".
 *
 * The followings are the available columns in table 'imprint':
 * @property string $id
 * @property string $user_id
 * @property string $imprint
 * @property integer $type
 * @property integer $status
 */

class Imprint extends CActiveRecord
{
	
	/** @var int */
	public static $IMPRINT_TYPE_AUTOMATIC = 0;
	/** @var int */
	public static $IMPRINT_TYPE_PERSONAL = 50;
	
	/** @var int */
	public static $IMPRINT_STATUS_READY = 0;
	/** @var int */
	public static $IMPRINT_STATUS_USED = 40;
	/** @var int */
	public static $IMPRINT_STATUS_KO = 80;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Imprint the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'imprint';
	}
	
	public function scopes() {
		return array(
			'lastAutomatic' => array(
				'order' => 'id DESC',
				'limit' => 1,
				'condition' => 'type='.self::$IMPRINT_TYPE_AUTOMATIC
			),
			'firstReady' => array(
				'order' => 'id ASC',
				'limit' => 1, 
				'condition' => 'type='.self::$IMPRINT_TYPE_AUTOMATIC.' AND status='.self::$IMPRINT_STATUS_READY
			)
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('imprint', 'required'),
			array('type, status', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>10),
			array('imprint', 'length', 'max'=>16),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, imprint, type, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'imprint' => 'Imprint',
			'type' => 'Type',
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('imprint',$this->imprint,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Assign an imprint to the user
	 * @param User $user the user
	 * @return boolean whether an imprint has been assigned to the user
	 */
	public function assignToUser($user)
	{
		$criteria = self::model()->firstReady()->getDbCriteria();
		$attributes = array('user_id'=>$user->id, 'status'=>self::$IMPRINT_STATUS_USED);
		return (self::model()->updateAll($attributes, $criteria) == 1);
	}

	/**
	 * Finds a single active record with the specified $imprint.
	 * @param $string $imprint primary key value(s).
	 * @return CActiveRecord the record found. Null if none is found.
	 */
	public function findByImprint($imprint) {
		Yii::trace(get_class($this).'.findByImprint()','system.db.ar.CActiveRecord');
		return $this->findByAttributes(array('imprint'=>$imprint));
	}

}