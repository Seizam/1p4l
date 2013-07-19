<?php
/* @var $this SiteController */

$this->pageTitle = 'FAQ - 1p4l.com';
?>

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

<div class="accordion" id="accordion1">
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse1">
				What is this ?
			</a>
		</div>
		<div id="collapse1" class="accordion-body collapse">
			<div class="accordion-inner">
				One Page For Life, or 1P4L to be shorter, is an online service. It offers a clean and quick way to share all your contact information.
			</div>
		</div>
	</div>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse2">
				Where is this ?
			</a>
		</div>
		<div id="collapse2" class="accordion-body collapse">
			<div class="accordion-inner">
				1P4L is made and hosted with love in France and it is available worldwide.
			</div>
		</div>
	</div>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse3">
				Why is this ?
			</a>
		</div>
		<div id="collapse3" class="accordion-body collapse">
			<div class="accordion-inner">
				1P4L solves the issue of sharing complicated information, like email addresses or social profile links. Everything is gathered and replaced by your simple imprint.
			</div>
		</div>
	</div>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse4">
				What is my imprint ?
			</a>
		</div>
		<div id="collapse4" class="accordion-body collapse">
			<div class="accordion-inner">
				Your imprint is the 5 letters and numbers describing your page : <code>1p4l.com/<b>b3ty9</b></code>. It is unique, eternal and designed to be as easy to share as possible.
			</div>
		</div>
	</div>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse5">
				Can I customize my page ?
			</a>
		</div>
		<div id="collapse5" class="accordion-body collapse">
			<div class="accordion-inner">
				You can choose your name, your short bio, your pictures and of course your links. Layout & design customization are not available yet.
			</div>
		</div>
	</div>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse6">
				Is it really free for life ?
			</a>
		</div>
		<div id="collapse6" class="accordion-body collapse">
			<div class="accordion-inner">
				Yes, once you've signed up, you keep your page & your imprint, for free, for life.
			</div>
		</div>
	</div>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse7">
				How do you make money ?
			</a>
		</div>
		<div id="collapse7" class="accordion-body collapse">
			<div class="accordion-inner">
				We don't make money directly from 1P4L. 1P4L is made by <a href="http://atelier.seizam.com">l'Atelier Web Seizam</a>, a B2B web development company. 1P4L is part of our research process.
			</div>
		</div>
	</div>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse8">
				Is 1P4L sustainable ?
			</a>
		</div>
		<div id="collapse8" class="accordion-body collapse">
			<div class="accordion-inner">
				Yes, 1P4L will offer premium services to provide income and security to the website.
			</div>
		</div>
	</div>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse9">
				Is 1P4L still evolving ?
			</a>
		</div>
		<div id="collapse9" class="accordion-body collapse">
			<div class="accordion-inner">
				Yes, 1P4L is just at its beta stage, it is actually very young. We have many ideas for tomorrow, we're always building something new or improving something not perfect.
			</div>
		</div>
	</div>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse10">
				What's next ?
			</a>
		</div>
		<div id="collapse10" class="accordion-body collapse">
			<div class="accordion-inner">
				Skins, custom imprints, social networks integration, contact list management, access management... And perhaps <?php echo CHtml::link('something you have in mind',array('site/contact')); ?> ?
			</div>
		</div>
	</div>
</div>
