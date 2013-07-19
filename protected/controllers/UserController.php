<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';

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
			array('allow', // everyone
				'actions' => array('captcha'),
				'users' => array('*'),
			),
			array('allow', // anonymous
				'actions' => array('create', 'activate', 'login'),
				'users' => array('?'),
			),
			array('allow', // authenticated
				'actions' => array('logout','update', 'uploadPortrait', 'deletePortrait'),
				'users' => array('@'),
			),
			array('allow', // admin
				'actions' => array('index', 'view', 'delete'),
				'users' => array('@'),
				'expression' => '$user->isAdmin',
			),
			array('deny', // non-match = default = deny
				'users' => array('*'),
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
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()) {
				Yii::app()->user->setFlash('success', 'LogIn successful. Welcome back!');
				$this->redirect(Yii::app()->user->returnUrl);
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout(false);
		Yii::app()->user->setFlash('warning', 'You have been logged out. See you later!');
		$this->redirect(Yii::app()->homeUrl);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$user = new User('insert');
		
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-create-form')
		{
			echo CActiveForm::validate($user);
			Yii::app()->end();
		}

		if (isset($_POST['User']))
		{
			$user->attributes = $_POST['User'];
			if ($user->save())
			{
				$token = Token::model()->createForUser($user);
				if ($token !== null)
				{
					if ($this->sendEmail($user->email, 'activate', array('user' => $user, 'token' => $token)))
					{
						// everything is ok
						Yii::app()->user->setFlash('success', 'Thanks for joining ! Please check your <b>email</b>.');
						$this->redirect(Yii::app()->homeUrl); // redirect to home and exit
					}
					else
					{
						// error while sending email
						$token->delete();
						$user->delete();
						Yii::app()->user->setFlash('error', 'Internal error while sending your activation email. Please try again.');
					}
				}
				else
				{
					// error while creating token
					$user->delete();
					Yii::app()->user->setFlash('error', 'Internal error. Please try again.');
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

	public function actionActivate($token)
	{
		$user = User::model()->findToActivate($token);
		
		if ( $user !== null && Imprint::model()->assignToUser($user) )
		{
			$user->activate();
			$user->token->delete();
			
			Yii::app()->user->setFlash('success', 'Your account is now active, congrats! Please login...');					
			$this->redirect(array('login'));
		}

		Yii::app()->user->setFlash('error', 'Sorry, account creation is not available for now. Please try again later.');
		$this->redirect(Yii::app()->homeUrl);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{

		$model = new User('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['User']))
			$model->attributes = $_GET['User'];

		$this->render('index', array(
			'model' => $model,
		));

	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model' => $this->loadModel($id),
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id = null)
	{
		if ($id === null) $id = Yii::app()->user->id;
		
		if (!Yii::app()->user->isAdmin && $id !== Yii::app()->user->id) {
			throw new CHttpException('403','You are not authorized to perform this action.');
		}
		
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if (isset($_POST['User']))
		{
			$model->attributes = $_POST['User'];
			if ($model->save())
				Yii::app()->user->setFlash('success', 'Headline updated !');
				$this->redirect(array('page/update', 'imprint' => $this->getUserImprint()));
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		// we only allow deletion via POST request
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * (Re)uploads a portrait.
	 * If upload is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the user
	 */
	public function actionUploadPortrait($id = null) {
		if ($id === null)
			$id = Yii::app()->user->id;

		if (!Yii::app()->user->isAdmin && $id !== Yii::app()->user->id) {
			throw new CHttpException(403, 'You are not authorized to perform this action.');
		}

		$imprint = Imprint::model()->findByUserIdEager($id);
		if ($imprint === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		$formModel = new ImageFileForm();

		if (isset($_POST['ImageFileForm'])) {
			$formModel->attributes = $_POST['ImageFileForm'];
			$formModel->image = CUploadedFile::getInstance($formModel, 'image');

			if ($formModel->validate() && !$formModel->image->hasError) {

				$image = Yii::app()->image->load($formModel->image->tempName);

				// Recommended order: resize, crop, sharpen, quality and rotate or flip		
				$image->resize(228, 228, ( $image->width / $image->height > 1 ? Image::HEIGHT : Image::WIDTH ));
				$image->crop(228, 228, 'center', 'center');
				$image->sharpen(20);
				$image->quality(90);
				$image->save($imprint->portraitAbsolutePath);

				unlink($formModel->image->tempName); // necessary ?

				Yii::app()->user->setFlash('success', 'Portrait successfully uploaded !');
				$this->redirect(array('page/update', 'imprint' => $imprint->imprint));
			}
		}

		$this->render('uploadPortrait', array(
			'model' => $formModel,
			// 'portrait' => file_exists($imprint->portraitAbsolutePath) ? $imprint->portraitUrl : null,
		));
	}

	/**
	 * Delete a portrait.
	 * The browser is always redirected to the 'view' page.
	 * @param integer $id the ID of the user
	 */
	public function actionDeletePortrait($id = null) {
		if ($id === null)
			$id = Yii::app()->user->id;

		if (!Yii::app()->user->isAdmin && $id !== Yii::app()->user->id) {
			throw new CHttpException(403, 'You are not authorized to perform this action.');
		}

		$imprint = Imprint::model()->findByUserIdEager($id);
		if ($imprint === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		$filePath = $imprint->portraitAbsolutePath;

		if (file_exists($filePath)) {
			if (unlink($filePath)) {
				Yii::app()->user->setFlash('success', 'Portrait successfully deleted !');
			} else {
				throw new CHttpException(500, 'Portrait deletion failed.');
			}
		}

		$this->redirect(array('page/update', 'imprint' => $imprint->imprint));
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
