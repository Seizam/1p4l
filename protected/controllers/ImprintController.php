<?php

class ImprintController extends Controller
{

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin 
				'actions' => array('customize'),
				'users' => array('@'),
				'expression' => '$user->isAdmin',
			),
			array('deny', // deny all users
				'users' => array('*'),
			),
		);
	}

	public function actionCustomize($imprint = null)
	{
		// DEBUG ONLY
		// $var = Yii::app()->user->model->mainImprint;
		// echo nl2br(str_replace(' ', '&nbsp;', print_r($var, true))); die();
		// END DEBUG
		if (($imprint == null) ||
				(($old = $this->loadImprintUserEager($imprint)) == null) ||
				($old->user === null))
		{
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		$model = new Imprint('customize');

		if (isset($_POST['Imprint']) && $model->customize($old, $_POST['Imprint']))
		{
			Yii::app()->user->setFlash('success', 'Done!');
			$this->redirect($this->getPageIndexUrl($model->user)); // fetch newly created record
		}

		$this->render('customize', array(
			'old' => $old,
			'model' => $model,
		));
	}

}
