<?php

/**
 * LinkTemplate class file
 * Represents an unknown link
 * Extended by specialized classes
 */
class UrlLinkTemplate extends LinkTemplate {
	
	
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
	 * @return string The button icon (eg. twitter)
	 */
	public function getButtonIcon() {
		switch ($this->link->type) {
			case Link::TYPE_URL_GITHUB :
				return 'github';
			case Link::TYPE_URL_LINKEDIN :
				return 'linkedin';
			case Link::TYPE_URL_VIADEO :
				return 'cogs';
			case Link::TYPE_URL_TWITTER :
				return 'twitter';
			case Link::TYPE_URL_FACEBOOK :
				return 'facebook';
			case Link::TYPE_URL_GOOGLEPLUS :
				return 'google-plus';
			case Link::TYPE_URL_PINTEREST :
				return 'pinterest';
			case Link::TYPE_URL_YOUTUBE :
			case Link::TYPE_URL_VIMEO :
				return 'play-circle';
			case Link::TYPE_URL_SOUNDCLOUD :
				return 'volume-up';
			case Link::TYPE_URL_500px:
			case Link::TYPE_URL_FLICKR :
				return 'camera';
			case Link::TYPE_URL :
			default :
				return 'link';
		}
	}
	
	/**
	 * 
	 * @return string The button label (eg. Github)
	 */
	public function getButtonLabel() {
		$matches = array();
		$pattern = '/^(https?:\/\/)?(www\.)?([a-z0-9\-\.]*)/i';
		preg_match($pattern, $this->link->link, $matches);
		return $matches[3];
	}
	
	/**
	 * 
	 * @return string The button target url (eg. http://www.seizam.com)
	 */
	public function getButtonUrl() {
		return $this->link->link;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function getButtonDisabled() {
		return false;
	}

}