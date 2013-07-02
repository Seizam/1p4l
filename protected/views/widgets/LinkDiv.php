<?php

/**
 * LinkButton widget class file.
 */
class LinkDiv extends CWidget {

	/**
	 * The Link AR
	 * @var LinkTemplate 
	 */
	public $linkTemplate = null;

	public function run() {
		$content = "<i class=\"icon-{$this->linkTemplate->getIcon()}\"></i>\n";
		$content .= "<div class=\"caption\">{$this->linkTemplate->getLabel()}</div>\n";
		
		$htmlOptions = array('class'=>"link-a span{$this->linkTemplate->getSpan()} {$this->linkTemplate->getSize()}");
		
		if ($this->linkTemplate->getDisabled()) {
			$htmlOptions['class'] .= ' disabled';
			echo "<div class=\"{$htmlOptions['class']}\">\n{$content}</div>";
		} else {
			echo CHtml::link($content, $this->linkTemplate->getUrl(), $htmlOptions);
		}
	
	}
}