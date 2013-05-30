<?php

/**
 * LinkTemplate class file
 * Represents an unknown link
 * Extended by specialized classes
 */
class AddressLinkTemplate extends LinkTemplate {
	
	
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
		return 'address';
	}
	
	/**
	 * 
	 * @return string The button icon (eg. twitter)
	 */
	public function getButtonIcon() {
		switch ($this->link->type) {
			case Link::TYPE_ADDRESS_PRO :
				return 'building';
				
			case Link::TYPE_ADDRESS :
			case Link::TYPE_ADDRESS_PERSO :
			default :
				return 'home';
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
			case Link::TYPE_ADDRESS_PRO :
				return 'pro';
			case Link::TYPE_ADDRESS_PERSO :
				return 'perso';
			case Link::TYPE_ADDRESS :
			default :
				return null;
		}
	}

}