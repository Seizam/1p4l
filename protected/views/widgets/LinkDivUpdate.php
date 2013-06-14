<?php

/**
 * LinkButton widget class file.
 */
class LinkDivUpdate extends CWidget {

	/**
	 * The Link AR
	 * @var Link 
	 */
	public $linkTemplate = null;

	public function run() {
		echo "<div class=\"span{$this->linkTemplate->getSpan()} div-link div-link-{$this->linkTemplate->getSize()}\">\n";
		
		echo "<i class=icon-{$this->linkTemplate->getIcon()}></i>\n";
		
		echo CHtml::link('<i class="icon-remove"></i>', array('link/delete', 'id' => $this->linkTemplate->getId()), array('class'=> 'pull-right btn-delete'));
		echo CHtml::link('<i class="icon-pencil"></i>', array('link/update', 'id' => $this->linkTemplate->getId()), array('class'=> 'pull-right btn-update'));
		
		
		echo "<div>\n";
		echo "{$this->linkTemplate->getLabel()}</div>\n";
		echo "</div>\n";
	}

}