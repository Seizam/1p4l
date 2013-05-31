<?php

/**
 * LinkTemplate class file
 * Represents an unknown link
 * Extended by specialized classes
 */
class LinkTemplate {

	/**
	 * The Link AR
	 * @var Link 
	 */
	protected $link = null;
	
	/**
	 * 
	 * @param Link $link
	 */
	protected function __construct($link) {
		$this->link = $link;
	}
	
	/**
	 * Create a template of the right LinkTemplate class
	 * @param Link $link
	 * @return LinkTemplate
	 */
	public static function newFromLink($link) {
		if ($link->isUrl()) {
			return UrlLinkTemplate::newFromLink($link);
		} elseif ($link->isService()) {
			return ServiceLinkTemplate::newFromLink($link);
		} elseif ($link->isEmail()) {
			return EmailLinkTemplate::newFromLink($link);
		} elseif ($link->isPhone()) {
			return PhoneLinkTemplate::newFromLink($link);
		} elseif ($link->isAddress()) {
			return AddressLinkTemplate::newFromLink($link);
		} else {
			return new LinkTemplate($link);
		}
	}
	
	/**
	 * 
	 * @return string The class of LinkTemplate (eg. url)
	 */
	public function getClass() {
		return 'unknown';
	}
	
	/**
	 * 
	 * @return string The  type (eg. default)
	 */
	public function getType() {
		return 'link';
	}
	
	/**
	 * 
	 * @return string The  size (eg. large)
	 */
	public function getSize() {
		return 'default';
	}
	
	/**
	 * 
	 * @return int The column width (spanN)
	 */
	public function getSpan() {
		return 6;
	}
	
	/**
	 * 
	 * @return string The  icon (eg. twitter)
	 */
	public function getIcon() {
		return 'question';
	}
	
	/**
	 * 
	 * @return string The  label (eg. Github)
	 */
	public function getLabel() {
		return $this->link->label == null ? $this->link->label : $this->link->link ;
	}
	
	/**
	 * 
	 * @return string The  legend (eg. Perso)
	 */
	public function getLegend() {
		return null;
	}
	
	/**
	 * 
	 * @return string The  target url (eg. http://www.seizam.com)
	 */
	public function getUrl() {
		return null;
	}
	
	/**
	 * 
	 * @return boolean The  disabled status (eg. true)
	 */
	public function getDisabled() {
		return true;
	}
	
	

}