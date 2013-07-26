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
	
	/**
	 * 
	 * @return string
	 */
	public function getLabel() {
		return null;
	}
	
	
	/**
	 * In case of special/fun bhavior
	 * @return array | string the url to redirect to
	 */
	public function getRedirect() {
		return null;
	}

}

class UrlLinkHelper extends LinkHelper {
	
	/**
	 * @var string 
	 */
	protected $protocol = 'http://', $subdomain, $domain, $query;
	
	/**
	 * @var array the websites settings 
	 */
	protected $definitions;
	
	/**
	 * 
	 * @param string $protocol
	 * @param string $subdomain
	 * @param string $domain
	 * @param string $query
	 */
	protected function __construct($protocol, $subdomain, $domain, $query) {
		$this->definitions = Link::getDefinitions();
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
		return $this->getTypeFromDomain();
	}
	
	public function getLabel() {
		return $this->definitions[$this->getTypeFromDomain()][1];
	}
	
	public function getTypeFromDomain() {
		foreach ($this->definitions as $type => $definition) {
			if ($definition[0] == $this->domain) {
				return $type;
			}
		}
		return Link::TYPE_URL;
	}
	
	/**
	 * @return string
	 */
	public function getLink() {
		return $this->protocol.$this->subdomain.$this->domain.$this->query;
	}
	
	/**
	 * In case of special/fun bhavior
	 * @return array | string the url to redirect to
	 */
	public function getRedirect() {
		switch ($this->domain) {
			case '1p4l.com' : return array('page/index', 'imprint'=>'b3ta7');
			default : return null;
		}
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