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
	 * @return string The  icon (eg. twitter)
	 */
	public function getIcon() {
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
	 * @return string The  label (eg. My Github)
	 */
	public function getLabel() {
		$label = '';
		if ($this->link->label != null) $label = $this->link->label . ': ';
		$label .= $this->link->link;
		return $label;
	}
	
	/**
	 * 
	 * @return string The  legend (eg. Perso)
	 */
	public function getLegend() {
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
	 * @return string The  target url (eg. http://www.seizam.com)
	 */
	public function getUrl() {
		return 'mailto:'.$this->link->link;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function getDisabled() {
		return false;
	}

}