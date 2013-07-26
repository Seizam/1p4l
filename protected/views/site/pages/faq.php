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
<?php
$accordion = array(
	array(
		'What is this ?',
		'One Page For Life, or 1P4L to be shorter, is an online service. It offers a clean and quick way to share all your contact information.'
	),
	array(
		'Where is this ?',
		'1P4L is made and hosted with love in France and it is available worldwide.'
	),
	array(
		'Why is this ?',
		'1P4L solves the issue of sharing complicated information, like email addresses or social profile links. Everything is gathered and replaced by your simple imprint.'
	),
	array(
		'What is my imprint ?',
		'Your imprint is the 5 letters and numbers describing your page : <code>1p4l.com/<b>b3ty9</b></code>. It is unique, eternal and designed to be as easy to share as possible.'
	),
	array(
		'Why is my imprint random ?',
		'Imprints are automagically generated to be short and easy to read, recognize, remember, spell and share. They might not look like much, but they\'re actually pretty clever.'
	),
	array(
		'What is the imprint generation algorithm ?',
		'As imprints are the base of our anti-spam and anti-theft systems. We cannot disclose how we make them.'
	),
	array(
		'Can I customize my page ?',
		'You can choose your name, your short bio, your pictures and of course your links. Layout & design customization are not available yet.'
	),
	array(
		'Can I share any link ?',
		'Yes you can. But at the moment 1P4L is optimized to share your social and professional profiles.'
	),
	array(
		'Are my information private ?',
		'<b>NO</b>. Everything you post on 1P4L is public. Everyone can see your information.'
	),
	array(
		'Should I put my phone and address ?',
		'Your choice, but be aware anyone can see your info. Better safe than sorry...'
	),
	array(
		'Is it really free for life ?',
		'<b>YES</b>, once you\'ve signed up, you keep your page & your imprint, for free, for life.'
	),
	array(
		'How do you make money ?',
		'We don\'t make money directly from 1P4L. 1P4L is made by <a href="http://atelier.seizam.com">The Seizam Web Atelier</a>, a B2B web development company. 1P4L is part of our research process.'
	),
	array(
		'Is 1P4L sustainable ?',
		'<b>YES</b>, 1P4L will offer premium services to provide income and security to the website.'
	),
	array(
		'Is 1P4L still evolving ?',
		'<b>YES</b>, 1P4L is just at its beta stage, it is actually very young. We have many ideas for tomorrow, we\'re always building something new or improving something not perfect.'
	),
	array(
		'What\'s next ?',
		'Skins, custom imprints, social networks integration, contact list management, access management... And perhaps ' . CHtml::link('something you have in mind', array('site/contact')) . ' ?'
	)
		)
?>

<div class="accordion" id="accordion1">
	<?php
	foreach ($accordion as $id => $item) {
	?>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse<?php echo $id ?>">
				<?php echo $item[0] ?>
			</a>
		</div>
		<div id="collapse<?php echo $id ?>" class="accordion-body collapse">
			<div class="accordion-inner">
				<?php echo $item[1] ?>
			</div>
		</div>
	</div>
	<?php
	}
	?>
</div>
