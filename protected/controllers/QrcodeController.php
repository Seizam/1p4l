<?php

class QrcodeController extends Controller
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
				'actions' => array('stream'),
				'users' => array('*'),
			),
			array('deny', // non-match = default = deny
				'users' => array('*'),
			),
		);
	}

	public function actionStream($filename = null)
	{
		if ($filename == null)
		{
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		$filename = strtolower($filename);
		$ext_length = strlen(PageQRCode::FILE_EXTENSION);
		if (substr($filename, -$ext_length) !== PageQRCode::FILE_EXTENSION)
		{
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		$main_part = substr($filename, 0, -($ext_length + 1)); // "+ 1" because of '.'
		$imprint = $this->loadImprintUserEager($main_part);
		if ( ! $imprint->isMain() )
		{
			$this->redirect($imprint->user->qrcode->url);
		}

		return Yii::app()->getRequest()->sendFile($imprint->user->qrcode->visibleFilename, @file_get_contents($imprint->user->qrcode->absolutePath));
	}

}
