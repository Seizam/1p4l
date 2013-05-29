<?php

/**
 * LinkButton widget class file.
 */
class LinkButton extends CWidget {

	/**
	 * The Link AR
	 * @var Link 
	 */
	public $link = null;

	public function run() {
		$this->widget('bootstrap.widgets.TbButton', array(
			'type' => $this->getType(),
			'size' => $this->getSize(),
			'icon' => $this->getIcon(),
			'label' => $this->getLabel(),
			'url' => $this->getUrl(),
			'block' => true,
		));
	}
	
	private function getType() {
		return 'default';
	}
	
	private function getSize() {
		return 'large';
	}
	
	private function getIcon() {
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
	
	private function getLabel() {
		if ($this->link->isUrl()) {
			return $this->getLabelForUrl();
		} elseif ($this->link->isService()) {
			return $this->getLabelForService();
		} else {
			return $this->link->link;
		}
	}
	
	private function getLabelForUrl() {
		return 'URL';
	}
	
	private function getLabelForService() {
		switch ($this->link->type) {
			case Link::TYPE_SERVICE_SKYPE :
				return 'facetime-video';
			case Link::TYPE_SERVICE :
			default :
				return $this->link->label;
		}
	}
	
	private function getUrl() {
		return $this->link->link;
	}

}