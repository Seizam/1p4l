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
		if (($imprint == null) ||
				(($old = Imprint::model()->findByImprintEager($imprint)) == null) ||
				($old->user === null))
		{
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		$new = new Imprint('customize');

		if (isset($_POST['Imprint']) && $new->customize($old, $_POST['Imprint']))
		{
			Yii::app()->user->setFlash('success', 'Done!');
			$this->redirect(array('page/index', 'imprint' => $new->imprint));
		}

		$this->render('customize', array(
			'old' => $old,
			'new' => $new,
		));
	}

}
