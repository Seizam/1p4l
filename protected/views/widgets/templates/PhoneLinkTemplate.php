<?php

/**
 * LinkTemplate class file
 * Represents an unknown link
 * Extended by specialized classes
 */
class PhoneLinkTemplate extends LinkTemplate {
	
	
	/**
	 * Create a template of the right LinkTemplate class
	 * @param Link $link
	 * @return LinkTemplate
	 */
	public static function newFromLink($link) {
		return new self($link);
	}
	
	/**
	 * 
	 * @return string The class of LinkTemplate (eg. url)
	 */
	public function getClass() {
		return 'phone';
	}
	
	/**
	 * 
	 * @return string The  icon (eg. twitter)
	 */
	public function getIcon() {
		return 'phone';
	}
	
	/**
	 * 
	 * @return string The  label (eg. Github)
	 */
	public function getLabel() {
		return $this->link->link;
	}
	
	public function getLegend() {
		switch ($this->link->type) {
			case Link::TYPE_PHONE_PRO :
				return 'pro';
			case Link::TYPE_PHONE_PERSO :
				return 'perso';
			case Link::TYPE_PHONE :
			default :
				return null;
		}
	}
	
	/**
	 * 
	 * @return string The  target url (eg. http://www.seizam.com)
	 */
	public function getUrl() {
		return 'tel:'.$this->link->link;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function getDisabled() {
		return false;
	}

}