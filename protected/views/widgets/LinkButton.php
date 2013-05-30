<?php

/**
 * LinkButton widget class file.
 */
class LinkButton extends CWidget {

	/**
	 * The Link AR
	 * @var Link 
	 */
	public $linkTemplate = null;
	
	public $span = 6;

	public function run() {
		$this->widget('bootstrap.widgets.TbButton', array(
			'type' => $this->linkTemplate->getButtonType(),
			'size' => $this->linkTemplate->getButtonSize(),
			'icon' => $this->linkTemplate->getButtonIcon(),
			'label' => $this->linkTemplate->getButtonLabel(),
			'url' => $this->linkTemplate->getButtonUrl(),
			'disabled' => $this->linkTemplate->getButtonDisabled(),
			'htmlOptions' => array('class'=> 'span'.$this->span)
			
		));
	}
}