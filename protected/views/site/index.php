<?php
/* @var $this SiteController */
$this->pageTitle = 'One Page For Life - ' . SHORT_BASE_URL;
?>

<h1 class="row-fluid">
	<?php echo CHtml::image('images/1p4l.png', 'One Page For Life', array('class' => 'span12')) ?>
</h1>
<div class="row-fluid index-buttons">
	<h2 class="span6">
		The fastest way to share your contact information.
	</h2>
	<?php
	$this->widget('bootstrap.widgets.TbButton', array(
		'buttonType' => 'link',
		'type' => 'primary',
		'url' => array('user/create'),
		'size' => 'large',
		'encodeLabel' => false,
		'label' => '<i class="icon-bolt"></i> SignUp',
		'htmlOptions' => array('class' => 'span3')
	));
	$this->widget('bootstrap.widgets.TbButton', array(
		'buttonType' => 'link',
		'url' => array('user/login'),
		'size' => 'large',
		'encodeLabel' => false,
		'label' => '<i class="icon-signin"></i> LogIn',
		'htmlOptions' => array('class' => 'span3')
	));
	?>
</div>
<div class="row-fluid index-menu">
	<?php
	echo CHtml::link('<i class="icon-info-sign"></i> About', array('site/static', 'view' => 'about'), array('class' => 'span2'))
	. ' '
	. CHtml::link('<i class="icon-question-sign"></i> FAQ', array('site/static', 'view' => 'faq'), array('class' => 'span2'))
	. ' '
	. CHtml::link('<i class="icon-heart"></i> Team', 'http://atelier.seizam.com', array('class' => 'span2'))
	. ' '
	. CHtml::link('<i class="icon-eye-open"></i> Look', 'http://twitter.github.io/bootstrap/', array('class' => 'span2'))
	. ' '
	. CHtml::link('<i class="icon-cog"></i> Power', 'http://www.yiiframework.com/', array('class' => 'span2'))
	. ' '
	. CHtml::link('<i class="icon-legal"></i> Legal', array('site/static', 'view' => 'legal'), array('class' => 'span2'));
	?>
</div>