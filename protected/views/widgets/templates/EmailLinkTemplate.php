<?php

/**
 * LinkTemplate class file
 * Represents an unknown link
 * Extended by specialized classes
 */
class EmailLinkTemplate extends LinkTemplate {
	
	
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
		return 'email';
	}
	
	/**
	 * 
	 * @return string The button icon (eg. twitter)
	 */
	public function getButtonIcon() {
		switch ($this->link->type) {
			case Link::TYPE_EMAIL_PRO :
				return 'envelope-alt';
				
			case Link::TYPE_ADDRESS :
			case Link::TYPE_ADDRESS_PERSO :
			default :
				return 'envelope';
		}
	}
	
	/**
	 * 
	 * @return string The button label (eg. Github)
	 */
	public function getButtonLabel() {
		return $this->link->link;
	}
	
	/**
	 * 
	 * @return string The button legend (eg. Perso)
	 */
	public function getButtonLegend() {
		switch ($this->link->type) {
			case Link::TYPE_EMAIL_PRO :
				return 'pro';
			case Link::TYPE_EMAIL_PERSO :
				return 'perso';
			case Link::TYPE_EMAIL :
			default :
				return null;
		}
	}
	
	/**
	 * 
	 * @return string The button target url (eg. http://www.seizam.com)
	 */
	public function getButtonUrl() {
		return 'mailto:'.$this->link->link;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function getButtonDisabled() {
		return false;
	}

}