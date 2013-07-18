<?php

class WebUser extends CWebUser
{

	private $_model=null;

	/**
	 * This method is called after the user is successfully logged in.
	 * @param  boolean $fromCookie whether the login is based on cookie.
	 */
	protected function afterLogin($fromCookie)
	{
		parent::afterLogin($fromCookie);

		$user = $this->getModel();
		if ($user!==null)
		{
			$user->touchOnLogin();
		}
	}
	
	/**
	 * This method is called before logging in a user.
	 * You may override this method to provide additional security check.
	 * For example, when the login is cookie-based, you may want to verify
	 * that the user ID together with a random token in the states can be found
	 * in the database. This will prevent hackers from faking arbitrary
	 * identity cookies even if they crack down the server private key.
	 * @param mixed $id the user ID. This is the same as returned by {@link getId()}.
	 * @param array $states a set of name-value pairs that are provided by the user identity.
	 * @param boolean $fromCookie whether the login is based on cookie
	 * @return boolean whether the user should be logged in
	 * @since 1.1.3
	 */
	protected function beforeLogin($id, $states, $fromCookie) {
		$this->returnUrl=array('page/index', 'imprint'=>User::model()->findByPk($id)->imprints[0]->imprint);
		return parent::beforeLogin($id, $states, $fromCookie);
	}

	/**
	 * 
	 * @return User The AR, or null if guest
	 */
	public function getModel()
	{
		$id = $this->id;
		if ($id !== null && ($this->_model === null || $this->_model->id != $id))
		{
			$this->_model = User::model()->findByPk($id);
		}

		return $this->_model;
	}

	/**
	 * Returns a value indicating whether the user is an admin.
	 * @return boolean whether the current application user is an admin.
	 */
	public function getIsAdmin()
	{
		return ( isset($this->model)
				&& in_array($this->model->email, Yii::app()->params['admins']) );
	}
}
