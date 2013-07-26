<?php

/**
 * LinkTemplate class file
 * Represents an unknown link
 * Extended by specialized classes
 */
class UrlLinkTemplate extends LinkTemplate {

	/**
	 * @var array the websites settings 
	 */
	protected $definitions;

	/**
	 * 
	 * @param Link $link
	 */
	protected function __construct($link) {
		$this->link = $link;
		$this->definitions = Link::getDefinitions();
	}

	/**
	 * Create a template of the right LinkTemplate class
	 * @param Link $link
	 * @return LinkTemplate
	 */
	public static function newFromLink($link) {
		return new UrlLinkTemplate($link);
	}

	/**
	 * 
	 * @return string The class of LinkTemplate (eg. url)
	 */
	public function getClass() {
		return 'url';
	}

	/**
	 * 
	 * @return string The  icon (eg. twitter)
	 */
	public function getIcon() {
		return $this->definitions[$this->link->type][2];
	}

	/**
	 * 
	 * @return string The  label (eg. Github)
	 */
	public function getLabel() {
		if ($this->link->label == null) {
			$matches = array();
			$pattern = '/^(https?:\/\/)?(www\.)?([a-z0-9\-\.]*)/i';
			preg_match($pattern, $this->link->link, $matches);
			return $matches[3];
		} else {
			return $this->link->label;
		}
	}

	/**
	 * 
	 * @return string The  target url (eg. http://www.seizam.com)
	 */
	public function getUrl() {
		return $this->link->link;
	}

	/**
	 * 
	 * @return boolean
	 */
	public function getDisabled() {
		return false;
	}

}