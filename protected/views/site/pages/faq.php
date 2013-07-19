<?php
/* @var $this SiteController */

$this->pageTitle = 'FAQ - 1p4l.com';
?>

<div class="page-header">
	<?php
	$this->widget('bootstrap.widgets.TbButton', array(
		'buttonType' => 'link',
		'type' => 'primary',
		'label' => '<i class="icon-envelope"></i> Ask',
		'url' => array('site/contact'),
		'encodeLabel' => false,
		'size' => 'large',
		'htmlOptions' => array('class' => 'pull-right')
	));
	?>
	<h1><i class="icon-question-sign"></i> FAQ <small>Question everything</small></h1>
</div>

<div class="accordion" id="accordion1">
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse1">
				Question 1 ?
			</a>
		</div>
		<div id="collapse1" class="accordion-body collapse">
			<div class="accordion-inner">
				Answer 1...
			</div>
		</div>
	</div>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse2">
				Question 2 ?
			</a>
		</div>
		<div id="collapse2" class="accordion-body collapse">
			<div class="accordion-inner">
				Answer 2...
			</div>
		</div>
	</div>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse3">
				Question 3 ?
			</a>
		</div>
		<div id="collapse3" class="accordion-body collapse">
			<div class="accordion-inner">
				Answer 3...
			</div>
		</div>
	</div>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseTwo">
				Question 4 ?
			</a>
		</div>
		<div id="collapseTwo" class="accordion-body collapse">
			<div class="accordion-inner">
				Answer 4...
			</div>
		</div>
	</div>
</div>
