<?php

/**
 * This is the model class for table "token".
 *
 * The followings are the available columns in table 'token':
 * @property string $id
 * @property string $user_id
 * @property string $token
 * @property string $created
 */
class Token extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Token the static model class
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
		return 'token';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('token', 'length', 'max'=>64),
			array('id, user_id, token, created', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
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
			'token' => 'Token',
			'created' => 'Created',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('token',$this->token,true);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 
	 * @param User $user
	 * @return Token The token instance, or null if a problem occured.
	 */
	public function createForUser($user)
	{
		$token = new Token('create');
		$token->user_id = $user->id;
		$token->token = md5(strval($user->id) . strval($user->email)) . md5(strval(microtime()) . strval(rand(0, 1000000)));
		$token->created = new CDbExpression('NOW()');
		if ($token->insert())
		{
			Yii::trace("Token->createForUser token {$token->token} for user {$token->user_id}");
			return $token; // ok
		}
		return null; // error
	}

}