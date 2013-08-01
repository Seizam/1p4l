<?php

class PortraitController extends Controller
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
			array('allow', // authenticated
				'actions' => array('upload', 'delete'),
				'users' => array('@'),
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
		$ext_length = strlen(Portrait::FILE_EXTENSION);
		if (substr($filename, -$ext_length) !== Portrait::FILE_EXTENSION)
		{
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		$main_part = substr($filename, 0, -($ext_length + 1)); // "+ 1" because of '.'
		$imprint = $this->loadImprintUserEager($main_part);
		if ( ! $imprint->isMain() )
		{
			$this->redirect($imprint->user->portrait->url);
		}

		if (!$imprint->user->portrait->exists())
		{
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return Yii::app()->getRequest()->sendFile($imprint->user->portrait->visibleFilename, @file_get_contents($imprint->user->portrait->absolutePath));
	}

	/**
	 * (Re)uploads a portrait.
	 * If upload is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the user
	 */
	public function actionUpload()
	{
		$user = $this->loadUserEager();

		$formModel = new ImageFileForm();

		if (isset($_POST['ImageFileForm']))
		{
			$formModel->attributes = $_POST['ImageFileForm'];
			$formModel->image = CUploadedFile::getInstance($formModel, 'image');

			if ($formModel->validate() && !$formModel->image->hasError)
			{

				$image = Yii::app()->image->load($formModel->image->tempName);

				// Save Original
				$image->save($user->portrait->originalAbsolutePathWithoutExtension . '.' . $image->ext);

				// Recommended order: resize, crop, sharpen, quality and rotate or flip		
				$image->resize(228, 228, ( $image->width / $image->height > 1 ? Image::HEIGHT : Image::WIDTH ));
				$image->crop(228, 228, 'center', 'center');
				$image->sharpen(20);
				$image->quality(90);
				$image->save($user->portrait->absolutePath);

				unlink($formModel->image->tempName); // necessary ?

				Yii::app()->user->setFlash('success', 'Portrait successfully uploaded !');
				$this->redirect($this->getPageUpdateUrl($user));
			}
		}

		$this->render('upload', array(
			'model' => $formModel,
		));
	}

	/**
	 * Delete a portrait.
	 * The browser is always redirected to the 'view' page.
	 * @param integer $id the ID of the user
	 */
	public function actionDelete()
	{
		$user = $this->loadUserEager();

		if ($user->portrait->exists())
		{
			if (unlink($user->portrait->absolutePath))
			{
				Yii::app()->user->setFlash('success', 'Portrait successfully deleted !');
			} else {
				throw new CHttpException(500, 'Portrait deletion failed.');
			}
		}

		$this->redirect($this->getPageUpdateUrl($user));
	}

}
