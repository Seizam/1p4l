<?php

class UserIdentity extends CUserIdentity
{

	const ERROR_ACCOUNT_INACTIVE = 30;
	/**
	 * @var string email
	 */
	public $email;

	/**
	 * @var User user
	 */
	private $_user = null;

	/**
	 * Constructor.
	 * @param string $username username
	 * @param string $password password
	 */
	public function __construct($email, $password)
	{
		$this->email = $email;
		$this->password = $password;
	}

	/**
	 * Authenticates a user based on {@link email} and {@link password}.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user = User::model()->findByAttributes(array('email' => $this->email));
		if ($user === null)
		{
			$this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
		}
		elseif (!CPasswordHelper::verifyPassword($this->password, $user->password))
		{
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		}
		elseif ($user->status != User::STATUS_ACTIVE)
		{
			$this->errorCode = self::ERROR_ACCOUNT_INACTIVE;
		}
		else
		{
			$this->_user = $user;
			$this->errorCode = self::ERROR_NONE;
		}
		return $this->errorCode === self::ERROR_NONE;
	}

	/**
	 * Returns the unique identifier for the identity.
	 * This method is required by {@link IUserIdentity}.
	 * @return int the unique identifier for the identity.
	 */
	public function getId()
	{
		return ($this->_user === null) ? 0 : $this->_user->id;
	}

	/**
	 * Returns the display name for the identity.
	 * The default implementation simply returns {@link username}.
	 * This method is required by {@link IUserIdentity}.
	 * @return string the display name for the identity.
	 */
	public function getName()
	{
		return $this->email;
	}

}