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
	 * @return string The button type (eg. default)
	 */
	public function getButtonType() {
		return 'link';
	}
	
	/**
	 * 
	 * @return string The button size (eg. large)
	 */
	public function getButtonSize() {
		return 'default';
	}
	
	/**
	 * 
	 * @return string The button icon (eg. twitter)
	 */
	public function getButtonIcon() {
		return 'question';
		switch ($this->link->type) {
			case Link::TYPE_URL :
				return 'link';
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
			case Link::TYPE_SERVICE :
				return 'wrench';
			case Link::TYPE_SERVICE_SKYPE :
				return 'facetime-video';
			case Link::TYPE_EMAIL :
			case Link::TYPE_EMAIL_PRO :
			case Link::TYPE_EMAIL_PERSO :
				return 'envelope';
			case Link::TYPE_PHONE :
			case Link::TYPE_PHONE_PRO :
			case Link::TYPE_PHONE_PERSO :
				return 'phone';
			case Link::TYPE_ADDRESS :
			case Link::TYPE_ADDRESS_PERSO :
				return 'home';
			case Link::TYPE_ADDRESS_PRO :
				return 'building';
			case Link::TYPE_UNKNOWN :
			default :
				return 'question';
		}
	}
	
	/**
	 * 
	 * @return string The button label (eg. Github)
	 */
	public function getButtonLabel() {
		return $this->link->label == null ? $this->link->label : $this->link->link ;
	}
	
	/**
	 * 
	 * @return string The button legend (eg. Perso)
	 */
	public function getButtonLegend() {
		return null;
	}
	
	/**
	 * 
	 * @return string The button target url (eg. http://www.seizam.com)
	 */
	public function getButtonUrl() {
		return null;
	}
	
	/**
	 * 
	 * @return boolean The button disabled status (eg. true)
	 */
	public function getButtonDisabled() {
		return true;
	}
	
	

}