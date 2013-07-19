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
	public function actionIndex($imprint = null, $id = null) {
		if ($imprint === null) {
			if ($id === null) {
				$id = Yii::app()->user->id;
			}
			$model = $this->loadModelFromUserId($id);
		} else {
			$model = $this->loadModelFromImprint($imprint);
		}
		
		Yii::import('application.views.widgets.templates.*');
		
		$this->render('index', array(
			'model' => $model,
			'portrait' => file_exists($model->portraitAbsolutePath) ? $model->portraitUrl : null,
			'QRCodeUrl' => $this->getQRCodeUrl($model->imprint)
		));
	}

	public function actionUpdate($imprint = null, $id = null) {
		if ($imprint === null) {
			if ($id === null) {
				$id = Yii::app()->user->id;
			}
			$model = $this->loadModelFromUserId($id);
		} else {
			$model = $this->loadModelFromImprint($imprint);
		}
		
		if (!Yii::app()->user->isAdmin && $model->user->id !== Yii::app()->user->id) {
			throw new CHttpException('403','You are not authorized to perform this action.');
		}
		
		Yii::import('application.views.widgets.templates.*');

		$this->render('update', array(
			'model' => $model,
			'portrait' => file_exists($model->portraitAbsolutePath) ? $model->portraitUrl : null,
		));

	}

	/**
	 * 
	 * @param string $imprint
	 * @return Imprint
	 * @throws CHttpException
	 */
	protected function loadModelFromImprint($imprint) {
		$model = Imprint::model()->findByImprintEager($imprint);
		if ($model === null || $model->user === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}
	
	/**
	 * 
	 * @param int $id User Id
	 * @return Imprint
	 * @throws CHttpException
	 */
	protected function loadModelFromUserId($id) {
		$model = Imprint::model()->findByUserIdEager($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

}