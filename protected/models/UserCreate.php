<?php

/**
 * UserCreateFormClass
 */
class UserCreate extends User
{

	public $passwordRepeat;
	public $verifyCode;

	/**
	 * @return array validation rules.
	 */
	public function rules()
	{
		return array_merge(parent::rules(), array(
			array('email, password, passwordRepeat, name, verifyCode', 'required'),
			array('email', 'unique', 'message' => 'This email adress is already used.'),
			array('status', 'default', 'value' => self::STATUS_EMAIL_TO_CONFIRM, 'setOnEmpty' => false),
			array('passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => 'You must enter the same password twice.'),
			array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements()),
		));
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), array(
			'verifyCode' => 'Verification Code',
			'passwordRepeat' => 'Password Repeat',
		));
	}

}