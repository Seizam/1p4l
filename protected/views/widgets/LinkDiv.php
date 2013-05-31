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

	public function run() {
		$this->widget('bootstrap.widgets.TbButton', array(
			'type' => $this->linkTemplate->getType(),
			'size' => $this->linkTemplate->getSize(),
			'icon' => $this->linkTemplate->getIcon(),
			'label' => '<div>'.$this->linkTemplate->getLabel().'</div>',
			'encodeLabel' => false,
			'url' => $this->linkTemplate->getUrl(),
			'disabled' => $this->linkTemplate->getDisabled(),
			//'block' => true,
			'htmlOptions' => array('class' => "span{$this->linkTemplate->getSpan()}"),
		));
	}
}