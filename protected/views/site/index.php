<?php
/* @var $this SiteController */
$this->pageTitle = 'One Page For Life - ' . SHORT_BASE_URL;
?>

<div class="row-fluid">
	<iframe src="http://player.vimeo.com/video/71084101" width="725" height="272" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
</div>
<div class="row-fluid index-buttons">
	<h2 class="span6">
		The fastest way to share your contact information.
	</h2>
	<?php
	if (Yii::app()->user->getIsGuest()) {
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
	} else {
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'link',
			'type' => 'primary',
			'url' => array('page/index','imprint'=>$this->getUserImprint()),
			'size' => 'large',
			'encodeLabel' => false,
			'label' => '<i class="icon-file"></i> My Page',
			'htmlOptions' => array('class' => 'span3')
		));
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'link',
			'url' => array('user/logout'),
			'size' => 'large',
			'encodeLabel' => false,
			'label' => '<i class="icon-signout"></i> LogOut',
			'htmlOptions' => array('class' => 'span3')
		));
	}
	?>
</div>
<div class="row-fluid index-menu">
	<?php
	echo CHtml::link('<i class="icon-eye-open"></i> Example', array('page/index', 'imprint' => 'b3ta9'), array('class' => 'span3'))
	. ' '
	. CHtml::link('<i class="icon-twitter"></i> Twitter', 'http://www.twitter.com/1Page4Life', array('class' => 'span3'))
	. ' '
	. CHtml::link('<i class="icon-info-sign"></i> About', array('site/static', 'view' => 'about'), array('class' => 'span3'))
	. ' '
	. CHtml::link('<i class="icon-question-sign"></i> FAQ', array('site/static', 'view' => 'faq'), array('class' => 'span3'));
	?>
</div>