<?php

/**
 * LinkTemplate class file
 * Represents an unknown link
 * Extended by specialized classes
 */
class ServiceLinkTemplate extends LinkTemplate {
	
	
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
		return 'service';
	}
	
	/**
	 * 
	 * @return string The button icon (eg. twitter)
	 */
	public function getButtonIcon() {
		switch ($this->link->type) {
			case Link::TYPE_SERVICE_SKYPE :
				return 'facetime-video';
				
			case Link::TYPE_SERVICE :
			default :
				return 'wrench';
		}
	}
	
	/**
	 * 
	 * @return string The button label (eg. Github)
	 */
	public function getButtonLabel() {
		switch ($this->link->type) {
			case Link::TYPE_SERVICE_SKYPE :
				return 'skype:'.$this->link->link;
				
			case Link::TYPE_SERVICE :
			default :
				return parent::getButtonLabel();
		}
	}

}