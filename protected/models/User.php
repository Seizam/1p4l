<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $created
 * @property string $modified
 * @property string $last_login
 * @property string $last_login_ip
 * @property string $name
 * @property string $catch
 * @property int $status
 */
class User extends CActiveRecord
{

	const STATUS_EMAIL_TO_CONFIRM = 0;
	const STATUS_ACTIVE = 10;
	const STATUS_PASSWORD_TO_CHANGE = 20;
	const STATUS_UNACTIVE = 90;
	
	/* Used for create() */
	public $passwordRepeat;
	public $verifyCode;

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
			array('name', 'length', 'max'=>128),
			array('password', 'length', 'max'=>45),
			array('email', 'length', 'max'=>256),
			array('catch', 'length', 'max'=>180),
			array('email', 'email'),
			
			// The following rules are used by create() ('insert' scenario)
			array('email, password, passwordRepeat, name, verifyCode', 'required', 'on'=>'insert'),
			array('email', 'unique', 'message' => 'This email address is already registered.', 'on'=>'insert'),
			array('passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => 'You must enter the same password twice.', 'on'=>'insert'),
			array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements(), 'on'=>'insert'),
			
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
			'token'=> array(self::HAS_ONE, 'Token', 'user_id'),
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
			'passwordRepeat' => 'Password Repeat',
			'created' => 'Created',
			'modified' => 'Modified',
			'last_login' => 'Last Login',
			'last_login_ip' => 'Last Login Ip',
			'name' => 'Name',
			'catch' => 'Catch',
			'verifyCode' => 'Verification Code',
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
	 * updates <code>last_login</code> and <code>last_login_ip</code> fields of
	 * the current record
	 * @return boolean whether the update is successful
	 */
	public function touchOnLogin()
	{
		Yii::trace('User->touchOnLogin() user=' . $this->id);
		$this->last_login = new CDbExpression('NOW()');
		$this->last_login_ip = Yii::app()->request->userHostAddress;
		return $this->update(array( 'last_login','last_login_ip'));
	}

	/**
	 * updates the field <code>status</code> of the current record from 
	 * <code>STATUS_EMAIL_TO_CONFIRM</code> to 
	 * <code>STATUS_ACTIVE</code>
	 * @return boolean whether the update is successful
	 */
	public function confirmEmail() {
		if ($this->status == self::STATUS_EMAIL_TO_CONFIRM)
		{
			$this->status = self::STATUS_ACTIVE;
			return $this->update();
		}
		return false;
	}

	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			$now = new CDbExpression('NOW()');
			
			$this->modified = $now;
			
			// Only on create()
			if($this->isNewRecord)
			{
				$this->password = CPasswordHelper::hashPassword($this->password);
				$this->created = $now;
				$this->last_login_ip = Yii::app()->request->userHostAddress;
				$this->status = self::STATUS_EMAIL_TO_CONFIRM;
			}
			
			return true;
		}
		else
		{
			return false;
		}
	}

}