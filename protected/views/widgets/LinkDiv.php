<?php

/**
 * LinkButton widget class file.
 */
class LinkDiv extends CWidget {

	/**
	 * The Link AR
	 * @var Link 
	 */
	public $linkTemplate = null;
	
	public $span = 6;

	public function run() {
		$this->widget('bootstrap.widgets.TbButton', array(
			'type' => $this->linkTemplate->getType(),
			'size' => $this->linkTemplate->getSize(),
			'icon' => $this->linkTemplate->getIcon(),
			'label' => '<span>'.$this->linkTemplate->getLabel().'</span>',
			'encodeLabel' => false,
			'url' => $this->linkTemplate->getUrl(),
			'disabled' => $this->linkTemplate->getDisabled(),
			'htmlOptions' => array('class'=> 'span'.$this->span)
			
		));
	}
}