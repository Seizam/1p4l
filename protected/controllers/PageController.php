<?php

class PageController extends Controller {

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
				'actions' => array('view','index'),
				'users' => array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions' => array('create', 'update'),
				'users' => array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array('admin', 'delete'),
				'users' => array('@'),
				'expression' => '$user->isAdmin',
			),
			array('deny', // deny all users
				'users' => array('*'),
			),
		);
	}

	/**
	 * 
	 * @param string $imprint
	 * @param int $id the user id
	 */
	public function actionIndex($imprint = null) {
		$user = $this->loadUserEagerOrRedirect($imprint);

		Yii::import('application.views.widgets.templates.*');
		$this->render('index', array(
			'model' => $user,
		));
	}

	public function actionUpdate($imprint = null) {
		$user = $this->loadUserEagerOrRedirect($imprint);

		if (!Yii::app()->user->isAdmin && $user->id !== Yii::app()->user->id) {
			throw new CHttpException(403,'You are not authorized to perform this action.');
		}

		Yii::import('application.views.widgets.templates.*');
		$this->render('update', array(
			'model' => $user,
		));
	}

}
