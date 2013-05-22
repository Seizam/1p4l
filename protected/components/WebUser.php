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
	 * 
	 * @return User The AR, or null if guest
	 */
	public function getModel()
	{
		$id = $this->id;
		if ($id !== null && ($this->_model === null || $this->_model->id != $id))
		{
			Yii::trace("WebUser->getModel(): looking for user {$id}");
			$this->_model = User::model()->findByPk($id);
		}

		Yii::trace('WebUser->getModel(): returning '.gettype($this->_model));
		return $this->_model;
	}
}
