<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
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
			array('allow',  // allow all users 
				'actions'=>array('index','view','create','captcha', 'confirmEmail'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$user = new User('insert');

		if (isset($_POST['User']))
		{
			$user->attributes = $_POST['User'];
			if ($user->save())
			{
				$token = Token::model()->createForUser($user);
				if ($token !== null)
				{
					if ($this->sendEmail($user->email, 'confirmEmail', array('user' => $user, 'token' => $token)))
					{
						// everything is ok
						Yii::app()->user->setFlash('success', 'Thank you for your registration. Please check your email.');
						$this->redirect(Yii::app()->homeUrl); // redirect to home and exit
					}
					else
					{
						// error while sending email
						$token->delete();
						$user->delete();
						Yii::app()->user->setFlash('error', 'Internal error while sending your activation email. Please retry.');
					}
				}
				else
				{
					// error while creating token
					$user->delete();
					Yii::app()->user->setFlash('error', 'Internal error. Please retry.');
				}		
			}
			// else: error while validating form
		}		

		// always clear sensitive data
		$user->password = '';
		$user->passwordRepeat = '';
		$user->verifyCode = '';

		$this->render('create', array(
			'model' => $user,
		));
	}

	public function actionConfirmEmail($token)
	{
		$token = Token::model()->with('user')->findByAttributes(array('token' => $token));

		if ($token !== null && $token->user !== null)
		{
			if ($token->user->confirmEmail()) {
				$token->delete();
				Yii::app()->user->setFlash('success', 'Your account is now active. You can login.');
				$this->redirect(array('site/login'));
			}
			else
			{
				Yii::app()->user->setFlash('error', 'Internal error. Please retry.');
			}
		}
		else
		{
			Yii::app()->user->setFlash('error', 'Invalid email confirmation link.');
		}

		$this->redirect(Yii::app()->homeUrl);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
