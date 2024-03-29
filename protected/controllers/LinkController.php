<?php

class LinkController extends Controller {

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/main';

	/**
	 * @return array action filters
	 */
	public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() {
		return array(
			array('allow', // allow all users to perform 'index' and 'view' actions
				'actions' => array('view'),
				'users' => array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions' => array('create', 'update', 'delete', 'up'),
				'users' => array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array('index', 'admin', 'delete'),
				'users' => array('@'),
				'expression' => '$user->isAdmin',
			),
			array('deny', // deny all users
				'users' => array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
		$model = new Link;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Link'])) {
			$model->attributes = $_POST['Link'];
			$model->user_id = Yii::app()->user->id;
			if ($model->save()) {
				if ($model->getRedirect() == null) {
					$this->redirect(array('page/update', 'imprint' => $this->getUserImprint()));
				} else {
					$this->redirect($model->getRedirect());
				}
			}
		}

		$this->render('create', array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		$model = $this->loadModel($id);
		
		if(!Yii::app()->user->isAdmin && $model->user_id !== Yii::app()->user->id) {
			throw new CHttpException('403','You are not authorized to perform this action.');
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Link'])) {
			$model->attributes = $_POST['Link'];
			if ($model->save())
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
	public function actionDelete($id) {

		$model = $this->loadModel($id);

		if(!Yii::app()->user->isAdmin && $model->user_id !== Yii::app()->user->id) {
			throw new CHttpException('403','You are not authorized to perform this action.');
		}

		$model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('page/update', 'id' => $model->user_id));
	}

	/**
	 * Moves up a link.
	 * @param integer $id the ID of the model to be move
	 */
	public function actionUp($id) {

		$model = $this->loadModel($id);

		if (!Yii::app()->user->isAdmin && $model->user_id !== Yii::app()->user->id) {
			throw new CHttpException('403', 'You are not authorized to perform this action.');
		}

		$model->moveUp();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('page/update', 'id' => $model->user_id));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex() {

		$dataProvider = new CActiveDataProvider('Link');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin() {
		$model = new Link('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Link']))
			$model->attributes = $_GET['Link'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 * @return Link
	 */
	public function loadModel($id) {
		$model = Link::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'link-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
