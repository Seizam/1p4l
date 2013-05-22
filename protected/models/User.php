<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $email
 * @property string $password
 * @property string $created
 * @property string $modified
 * @property string $last_login
 * @property string $last_login_ip
 * @property string $name
 * @property string $catch
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, password', 'required'),
			array('email, name, password', 'length', 'max'=>45),
			array('catch', 'length', 'max'=>180),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email, created, modified, last_login, last_login_ip, name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'imprints' => array(self::HAS_MANY, 'Imprint', 'user_id'),
            'links'=> array(self::HAS_MANY, 'Link', 'user_id'),
 		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email',
			'password' => 'Password',
			'created' => 'Created',
			'modified' => 'Modified',
			'last_login' => 'Last Login',
			'last_login_ip' => 'Last Login Ip',
			'name' => 'Name',
			'catch' => 'Catch',
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('last_login',$this->last_login,true);
		$criteria->compare('last_login_ip',$this->last_login_ip,true);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 
	 */
	public function touchOnLogin()
	{
		Yii::trace('User->touchOnLogin on user ' . $this->id);
		$this->last_login_ip = Yii::app()->request->userHostAddress;
		$this->last_login = new CDbExpression('NOW()');
		$this->update(array('last_login_ip', 'last_login'));
	}

}