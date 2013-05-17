<?php

/**
 * UserCreateFormClass
 * Used to keep Create User Form Data
 */
class UserCreateForm extends CFormModel
{
    
    public $email;
    public $password;
    public $name;
    public $catch;
	public $verifyCode;

	/**
	 * @return array validation rules.
	 */
	public function rules()
	{
		return array(
			array('email, password', 'required'),
			array('email, name, password', 'length', 'max'=>45),
			array('email', 'email'),
			array('catch', 'length', 'max'=>180),
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}
    
	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'verifyCode'=>'Verification Code',
		);
	}

}