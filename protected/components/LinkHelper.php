<?php

/**
 * LinkHelper class file.
 *
 * @author Clément Dietschy <clement@seizam.com>
 * @link http://www.seizam.com/
 * @license GPL3
 */

class LinkHelper {
	/**
	 * @var string 
	 */
	protected $link;
	
	/**
	 * @param string $link
	 */
	protected function __construct($link) {
		$this->link = $link;
	}
	
	/**
	 * @param string $link
	 * @return \LinkHelper
	 */
	public static function newLinkHelper($link, $iterate = true) {
		if ($iterate) {
			return UrlLinkHelper::newLinkHelper($link);
		} else {
			return new LinkHelper($link);
		}
	}
	
	/**
	 * @return string
	 */
	public function getLink() {
		return CHtml::encode($this->link);
	}
	
	/**
	 * @return int
	 */
	public function getType() {
		return Link::TYPE_UNKNOWN;
	}
	
	public function getLabel() {
		return null;
	}

}

class UrlLinkHelper extends LinkHelper {
	
	/**
	 * @var string 
	 */
	protected $protocol = 'http://', $subdomain, $domain, $query;
	
	/**
	 * 
	 * @param string $protocol
	 * @param string $subdomain
	 * @param string $domain
	 * @param string $query
	 */
	protected function __construct($protocol, $subdomain, $domain, $query) {
		if ($protocol != null) $this->protocol = strtolower($protocol);
		$this->subdomain = strtolower($subdomain);
		$this->domain = strtolower($domain);
		$this->query = $query;
	}
	
	/**
	 * 
	 * @param string $link
	 * @param boolean $iterate
	 * @return \UrlLinkHelper
	 */
	public static function newLinkHelper($link, $iterate = true) {
		$pattern = '/^(https?:\/\/)?([a-z0-9\-\.]*\.)?([a-z0-9\-]+\.[a-z]{2,63})(\/.*)?$/i';
		$matches = array();
		Yii::log($link,'trace','application');
		if (preg_match($pattern, $link, $matches)) {
			if (!isset($matches[4])) $matches[4] = null;
			return new UrlLinkHelper($matches[1], $matches[2], $matches[3], $matches[4]);
		} else {
			Yii::log(print_r($matches, true),'trace','application');
			return EmailLinkHelper::newLinkHelper($link, false);
		}
	}
	
	/**
	 * @return int
	 */
	public function getType() {
		switch ($this->domain) {
			case 'github.com' : return Link::TYPE_URL_GITHUB;
			case 'linkedin.com' : return Link::TYPE_URL_LINKEDIN;
			case 'viadeo.com' : return Link::TYPE_URL_VIADEO;
			case 'twitter.com' : return Link::TYPE_URL_TWITTER;
			case 'facebook.com' : return Link::TYPE_URL_FACEBOOK;
			case 'google.com' : return Link::TYPE_URL_GOOGLEPLUS;
			case 'pinterest.com' : return Link::TYPE_URL_PINTEREST;
			case 'youtube.com' : return Link::TYPE_URL_YOUTUBE;
			case 'vimeo.com' : return Link::TYPE_URL_VIMEO;
			case 'soundcloud.com' : return Link::TYPE_URL_SOUNDCLOUD;
			case '500px.com' : return Link::TYPE_URL_500px;
			case 'flickr.com' : return Link::TYPE_URL_FLICKR;
			case 'tumblr.com' : return Link::TYPE_URL_TUMBLR;
			default : return Link::TYPE_URL;
		}
		
	}
	
	public function getLabel() {
		switch ($this->domain) {
			case 'github.com' : return 'My Github';
			case 'linkedin.com' : return 'My LinkedIn';
			case 'viadeo.com' : return 'My Viadeo';
			case 'twitter.com' : return 'My Twitter';
			case 'facebook.com' : return 'My Facebook';
			case 'google.com' : return 'My Google+';
			case 'pinterest.com' : return 'My Pinterest';
			case 'tumblr.com' : return 'My Tumblr';
			case 'youtube.com' : return 'My YouTube';
			case 'vimeo.com' : return 'My Vimeo';
			case 'soundcloud.com' : return 'My SoundCloud';
			case '500px.com' : return 'My 500px';
			case 'flickr.com' : return 'My Flickr';
			case 'instagram.com' : return 'My Instagram';
			default : return $this->domain;
		}
		
	}
	
	/**
	 * @return string
	 */
	public function getLink() {
		return $this->protocol.$this->subdomain.$this->domain.$this->query;
	}
}

class EmailLinkHelper extends LinkHelper {
	
	/**
	 * @var string 
	 */
	protected $local, $subdomain, $domain;
	
	/**
	 * 
	 * @param string $local
	 * @param string $subdomain
	 * @param string $domain
	 */
	protected function __construct($local, $subdomain, $domain) {
		$this->local = $local;
		$this->subdomain = strtolower($subdomain);
		$this->domain = strtolower($domain);
	}
	
	/**
	 * 
	 * @param string $link
	 * @param boolean $iterate
	 * @return \EmailLinkHelper
	 */
	public static function newLinkHelper($link, $iterate = true) {
		$pattern = '/^(mailto:)?(.{1,64})@([a-z0-9\-\.]*\.)?([a-z0-9\-]+\.[a-z]{2,63})$/i';
		$matches = array();
		if (preg_match($pattern, $link, $matches)) {
			return new EmailLinkHelper($matches[2], $matches[3], $matches[4]);
		} else {
			return PhoneLinkHelper::newLinkHelper($link, false);
		}
	}
	
	/**
	 * @return string
	 */
	public function getLink() {
		return $this->local.'@'.$this->subdomain.$this->domain;
	}
	
	/**
	 * @return int
	 */
	public function getType() {
		return Link::TYPE_EMAIL;
	}
}

class PhoneLinkHelper extends LinkHelper {
	
	/**
	 * @var string 
	 */
	protected $country, $numbers;
	
	/**
	 * 
	 * @param string $local
	 * @param string $subdomain
	 * @param string $domain
	 */
	protected function __construct($country, $numbers) {
		$this->country = trim($country);
		$this->numbers = trim($numbers);
	}
	
	/**
	 * 
	 * @param string $link
	 * @param boolean $iterate
	 * @return \EmailLinkHelper
	 */
	public static function newLinkHelper($link, $iterate = true) {
		$worklink = str_replace(array('.','_','-','/','\\',','), ' ' ,$link);
		$pattern = '/^(tel:)?(\+[0-9]{1,4})?([0-9\(\) ]{3,})$/i';
		$matches = array();
		if (preg_match($pattern, $worklink, $matches)) {
			return new PhoneLinkHelper($matches[2], $matches[3]);
		} else {
			return ServiceLinkHelper::newLinkHelper($link, false);
		}
	}
	
	/**
	 * @return string
	 */
	public function getLink() {
		$link = $this->numbers;
		if ($this->country != null) $link = $this->country. ' ' . $link;
		return $link;
	}
	
	/**
	 * @return int
	 */
	public function getType() {
		return Link::TYPE_PHONE;
	}
}

class ServiceLinkHelper extends LinkHelper {
	
	/**
	 * @var string 
	 */
	protected $service, $query;
	
	/**
	 * @param string $service
	 * @param string $query
	 */
	protected function __construct($service, $query) {
		$this->service = strtolower($service);
		$this->query = $query;
	}
	
	/**
	 * 
	 * @param string $link
	 * @param boolean $iterate
	 * @return \EmailLinkHelper
	 */
	public static function newLinkHelper($link, $iterate = true) {
		$pattern = '/^([a-z]{3,}):([\w]+)$/i';
		$matches = array();
		if (preg_match($pattern, $link, $matches)) {
			Yii::log(print_r($matches, true), 'trace', 'apps.bedhed');
			return new ServiceLinkHelper($matches[1], $matches[2]);
		} else {
			return AddressLinkHelper::newLinkHelper($link, false);
		}
	}
	
	/**
	 * @return string
	 */
	public function getLink() {
		return $this->service.':'.$this->query;
	}
	
	/**
	 * @return int
	 */
	public function getType() {
		switch ($this->service) {
			case 'skype': return Link::TYPE_SERVICE_SKYPE;
			default : return Link::TYPE_SERVICE;
		}
	}
}

class AddressLinkHelper extends LinkHelper {
	
	
	/**
	 * 
	 * @param string $link
	 * @param boolean $iterate
	 * @return \EmailLinkHelper
	 */
	public static function newLinkHelper($link, $iterate = true) {
		$pattern = '/^([0-9]{1,})(.+)$/i';
		if (preg_match($pattern, $link)) {
			return new AddressLinkHelper($link, true);
		} else {
			return LinkHelper::newLinkHelper($link, false);
		}
	}
	
	/**
	 * @return int
	 */
	public function getType() {
		return Link::TYPE_ADDRESS;
	}
}