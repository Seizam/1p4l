<?php
/* @var $this SiteController */
$this->pageTitle = 'One Page For Life - ' . SHORT_BASE_URL;
$this->layoutTitle = CHtml::link(SHORT_BASE_URL, array('site/static/about'));
?>

<div class="row-fluid">
	<?php echo CHtml::image('images/1p4l.png', 'One Page For Life', array('class' => 'span12')) ?>
</div>
<div class="row-fluid index-menu">
	<?php
	echo CHtml::link('<i class="icon-info-sign"></i> About', array('site/static/about'), array('class' => 'span2'))
	. ' '
	. CHtml::link('<i class="icon-question-sign"></i> FAQ', array('site/static/faq'), array('class' => 'span2'))
	. ' '
	. CHtml::link('<i class="icon-heart"></i> Team', 'http://atelier.seizam.com', array('class' => 'span2'))
	. ' '
	. CHtml::link('<i class="icon-eye-open"></i> Look', 'http://twitter.github.io/bootstrap/', array('class' => 'span2'))
	. ' '
	. CHtml::link('<i class="icon-cog"></i> Power', 'http://www.yiiframework.com/', array('class' => 'span2'))
	. ' '
	. CHtml::link('<i class="icon-legal"></i> Legal', array('site/static/legal'), array('class' => 'span2'));
	?>
</div>