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
	 * @return string The  icon (eg. twitter)
	 */
	public function getIcon() {
		switch ($this->link->type) {
			case Link::TYPE_URL_GITHUB :
				return 'github-sign';
			case Link::TYPE_URL_LINKEDIN :
				return 'linkedin-sign';
			case Link::TYPE_URL_VIADEO :
				return 'cogs';
			case Link::TYPE_URL_TWITTER :
				return 'twitter';
			case Link::TYPE_URL_FACEBOOK :
				return 'facebook-sign';
			case Link::TYPE_URL_GOOGLEPLUS :
				return 'google-plus-sign';
			case Link::TYPE_URL_PINTEREST :
				return 'pinterest-sign';
			case Link::TYPE_URL_TUMBLR :
				return 'tumblr-sign';
			case Link::TYPE_URL_YOUTUBE :
				return 'youtube';
			case Link::TYPE_URL_VIMEO :
				return 'play-circle';
			case Link::TYPE_URL_SOUNDCLOUD :
				return 'volume-up';
			case Link::TYPE_URL_500px:
				return 'camera';
			case Link::TYPE_URL_FLICKR :
				return 'flickr';
			case Link::TYPE_URL_INSTAGRAM :
				return 'instagram';
			case Link::TYPE_URL :
			default :
				return 'link';
		}
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