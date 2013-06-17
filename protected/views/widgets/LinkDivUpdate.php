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
		$content = "<i class=icon-{$this->linkTemplate->getIcon()}></i>\n";
		$content .= "<div>{$this->linkTemplate->getLabel()}</div>\n";
		
		$toolbox = "<div class=\"toolbox\">";
		$toolbox .= CHtml::link('<i class="icon-pencil"></i>', array('link/update', 'id' => $this->linkTemplate->getId()));
		$toolbox .= " ";
		$toolbox .= CHtml::link('<i class="icon-remove"></i>', array('link/delete', 'id' => $this->linkTemplate->getId()));
		$toolbox .= "</div>";
		
		$htmlOptions = array('class'=>"link-div span{$this->linkTemplate->getSpan()} {$this->linkTemplate->getSize()}");
		
		echo "<div class=\"{$htmlOptions['class']}\">\n{$toolbox}{$content}</div>";
	}

}