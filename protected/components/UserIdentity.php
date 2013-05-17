<?php

class UserIdentity extends CUserIdentity
{
    
    /**
	 * @var string email
	 */
	public $email;
    
    /**
	 * @var int _id
	 */
    private $_id;
    
    /**
	 * Constructor.
	 * @param string $username username
	 * @param string $password password
	 */
	public function __construct($email,$password)
	{
		$this->email=$email;
		$this->password=$password;
	}
    
	/**
	 * Authenticates a user based on {@link email} and {@link password}.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
        $user = User::model()->findByAttributes(array('email'=>$this->email));
        if ($user === null) {
            $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
        } elseif (!CPasswordHelper::verifyPassword($this->password, $user->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->_id = $user->id;
            
            // We do not use state yet.
            // $this->setState('title', $record->title);
            
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode;
	}
    
    /**
	 * Returns the unique identifier for the identity.
	 * This method is required by {@link IUserIdentity}.
	 * @return int the unique identifier for the identity.
	 */
	public function getId()
	{
		return $this->email;
	}

	/**
	 * Returns the email for the identity.
	 * This method is required by {@link IUserIdentity}.
	 * @return string the email for the identity.
	 */
	public function getEmail()
	{
		return $this->email;
	}
}