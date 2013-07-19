<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			'static'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		$user = Yii::app()->user->model;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{	
				if ($this->sendEmail(Yii::app()->params['adminEmail'], 'contact', array('model' => $model)))
				{
					// everything is ok
					Yii::app()->user->setFlash('success','Thanks for saying something. We\'ll answer as soon as possible.');
					$this->redirect(Yii::app()->homeUrl); // redirect to home and exit
				}
				else
				{
					// error while sending email
					Yii::app()->user->setFlash('error', 'Internal error while sending your message. Please try again.');
				}
			}
		}
		$this->render('contact',array('model'=>$model, 'user'=>$user));
	}
}