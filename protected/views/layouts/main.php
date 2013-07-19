<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="en" />


		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
		<link href='http://fonts.googleapis.com/css?family=Raleway:400,100' rel='stylesheet' type='text/css'>
			<?php Yii::app()->bootstrap->register(); ?>
			<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

				<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
				</head>

				<body class="opfl">
					<div class="container" id="page">
						<?php
						$this->widget('bootstrap.widgets.TbAlert');
						?>
						<div class="row-fluid">
							<h3 class="span6" id="title"><?php echo $this->layoutTitle ?></h3>
							<?php
							$this->widget('zii.widgets.CMenu', array('items' => $this->menu,
								'id' => 'menu',
								'encodeLabel' => false,
								'htmlOptions' => array('class' => 'span6'),
									)
							);
							?>
						</div>
						<div id="mainframe">
<?php echo $content; ?>
						</div>
						<div class="row-fluid">
							<div class="span12" id="footer">
								<?php
								echo CHtml::link('<i class="icon-twitter"></i>', 'http://www.twitter.com/1Page4Life')
								. ' '
								. CHtml::link('<i class="icon-info-sign"></i>', array('site/static', 'view' => 'about'))
								. ' '
								. CHtml::link('<i class="icon-question-sign"></i>', array('site/static', 'view' => 'faq'))
								. ' '
								. CHtml::link('<i class="icon-envelope"></i>', array('site/contact'))
								. ' '
								. CHtml::link('<i class="icon-heart"></i>', 'http://atelier.seizam.com')
								. ' '
								. CHtml::link('<i class="icon-legal"></i>', array('site/static', 'view' => 'legal'));
								?>
							</div>
						</div><!-- footer -->
					</div><!-- page -->
				</body>
				</html>
