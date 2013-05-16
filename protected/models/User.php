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
			array('email, password, created, modified, last_login, last_login_ip', 'required'),
			array('email, last_login_ip, name', 'length', 'max'=>45),
			array('password', 'length', 'max'=>128),
			array('catch', 'length', 'max'=>180),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email, password, created, modified, last_login, last_login_ip, name, catch', 'safe', 'on'=>'search'),
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
		$criteria->compare('password',$this->password,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('last_login',$this->last_login,true);
		$criteria->compare('last_login_ip',$this->last_login_ip,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('catch',$this->catch,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}