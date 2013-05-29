<?php

class PageController extends Controller {

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';

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
				'actions' => array('create', 'update'),
				'users' => array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array('index', 'admin', 'delete'),
				'users' => $this->getAdminNames(),
			),
			array('deny', // deny all users
				'users' => array('*'),
			),
		);
	}

	public function actionIndex($imprint) {
		$this->render('index', array('model' => $this->loadModel($imprint)));
	}

	public function actionUpdate() {
		$this->render('update');
	}

	public function loadModel($imprint) {
		$model = Imprint::model()->with('user', 'user.links')->findByImprint($imprint);
		if ($model->user === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

}