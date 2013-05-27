<?php

class UserIdentity extends CUserIdentity
{

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
		else
		{
			$this->user = $user;
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
		return ($this->user === null) ? 0 : $this->user->id;
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