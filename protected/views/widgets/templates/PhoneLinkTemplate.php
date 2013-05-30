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
	 * @return string The button icon (eg. twitter)
	 */
	public function getButtonIcon() {
		return 'phone';
	}
	
	/**
	 * 
	 * @return string The button label (eg. Github)
	 */
	public function getButtonLabel() {
		return $this->link->link;
	}
	
	public function getButtonLegend() {
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
	 * @return string The button target url (eg. http://www.seizam.com)
	 */
	public function getButtonUrl() {
		return 'tel:'.$this->link->link;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function getButtonDisabled() {
		return false;
	}

}