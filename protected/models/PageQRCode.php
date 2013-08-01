<?php

final class PageQRCode
{

	const FILE_EXTENSION = 'png';

	private $user;

	private function __construct($user)
	{
		$this->user = $user;
	}

	/**
	 * PHP getter magic method.
	 * This method is overridden so that getters can be accessed like properties.
	 * @param string $name property name
	 * @return mixed property value
	 */
	public function __get($name)
	{
		$getter = 'get' . ucfirst($name);
		if (method_exists($this, $getter))
		{
			return $this->$getter();
		}
		// else
		return null;
	}

	/**
	 * Factory
	 * @param User $user
	 * @return PageQRCode
	 */
	public static function model($user)
	{
		return new PageQRCode($user);
	}

	/**
	 * 
	 * @return string "{imprint}.{self::FILE_EXTENSION}"
	 */
	public function getVisibleFilename()
	{
		return $this->user->mainImprint->imprint . '.' . self::FILE_EXTENSION;
	}

	public function getContainerFolder()
	{
		return Yii::app()->getBasePath() . '/qrcode';
	}

	/**
	 * @return string Absolute filesystem path
	 */
	public function getAbsolutePath()
	{
		return $this->getContainerFolder() . '/' . $this->getVisibleFilename();
	}

	/**
	 * Get the QRCode image url and create it if necessary
	 * @param boolean $check Check if file exist (Default TRUE)
	 * @param boolean $force Force the creation (Default FALSE)
	 * @return string The QRCode's url
	 */
	public function getUrl($check = true, $force = false)
	{
		$fileName = $this->getVisibleFilename();
		$filePath = $this->getAbsolutePath();

		if (($check && !file_exists($filePath)) || $force)
		{
			$data = Yii::app()->createAbsoluteUrl('page/index', array('imprint' => $this->user->mainImprint->imprint));
			QRCodeGenerator::save(
					$data, // data
					realpath($this->getContainerFolder()), // container folder
					$fileName); // filename
		}

		$fileUrl = Yii::app()->baseUrl . '/qrcode/' . $fileName;

		return $fileUrl;
	}

}
