<?php

class Konami extends CWidget
{

	public function run()
	{

		$assetsPath = Yii::getPathOfAlias('ext.konami.assets') . DIRECTORY_SEPARATOR . 'konami.js';
		// echo 'plop'. $assetsPath . 'plop'; die;
		$assetsUrl = Yii::app()->assetManager->publish($assetsPath, true, -1, false);

		/** @var CClientScript $cs */
		$cs = Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile($assetsUrl, CClientScript::POS_END);

	}

}