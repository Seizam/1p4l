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
		
		$this->returnUrl = array('page/index', 'imprint'=>$this->model->imprints[0]->imprint);

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
