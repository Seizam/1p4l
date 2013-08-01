<?php

final class Portrait
{

	const FILE_EXTENSION = 'jpg';

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
	 * @return Portrait
	 */
	public static function model($user)
	{
		return new Portrait($user);
	}

	/**
	 * 
	 * @return string "{imprint}.{self::FILE_EXTENSION}"
	 */
	public function getVisibleFilename()
	{
		return $this->user->mainImprint->imprint . '.' . self::FILE_EXTENSION;
	}

	/**
	 * 
	 * @return string "{imprint}.{self::FILE_EXTENSION}"
	 */
	public function getInternalFilename()
	{
		return $this->user->id . '.' . self::FILE_EXTENSION;
	}

	/**
	 * @return string Absolute filesystem path
	 */
	public function getAbsolutePath()
	{
		return Yii::app()->getBasePath() . '/portrait/' . $this->getInternalFilename();
	}

	/**
	 * @param User $user
	 * @return string Absolute filesystem path without extension
	 */
	public function getOriginalAbsolutePathWithoutExtension()
	{
		return Yii::app()->getBasePath() . '/portrait/original/' . $this->user->id;
	}

	/**
	 * @param User $user
	 * @return string|null Relative URL or null when not available
	 */
	public function getUrl()
	{
		return $this->exists() ? Yii::app()->getBaseUrl() . '/portrait/' . $this->getVisibleFilename() : null;
	}

	/**
	 * 
	 * @return boolean
	 */
	public function exists()
	{
		return file_exists($this->getAbsolutePath());
	}

}
