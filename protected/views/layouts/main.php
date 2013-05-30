<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="en" />

		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />

		<title><?php echo CHtml::encode($this->pageTitle); ?></title>

		<?php Yii::app()->bootstrap->register(); ?>
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
	</head>

	<body class="opfl">
		<div class="container" id="page">
			<div class="row-fluid">
				<div class="span12">
					<?php
					$alertConfig = array('block' => true, 'fade' => true, 'closeText' => '&times;');
					$this->widget('bootstrap.widgets.TbAlert', array(
						'block' => true, // display a larger alert block?
						'fade' => true, // use transitions?
						'closeText' => '&times;', // close link text - if set to false, no close link is displayed
						'alerts' => array(// configurations per alert type (success, info, warning, error or danger)
							'success' => $alertConfig,
							'info' => $alertConfig,
							'warning' => $alertConfig,
							'error' => $alertConfig,
							'danger' => $alertConfig,
						),
					));
					?>
				</div>
			</div>
			<div id="mainframe">
				<?php echo $content; ?>
			</div>
			<div class="row-fluid" id="footer">
				<div class="span2 offset10 align-center">
					<?php echo CHtml::link('<i class="icon-question-sign"></i>', array('site/about'))
							.' '
							.CHtml::link('<i class="icon-heart"></i>', 'http://atelier.seizam.com')
							.' '
							.CHtml::link('<i class="icon-eye-open"></i>', 'http://twitter.github.io/bootstrap/')
							.' '
							.CHtml::link('<i class="icon-cog"></i>', 'http://www.yiiframework.com/')
							.' '
							.CHtml::link('<i class="icon-legal"></i>', array('site/legal'));
					?>
				</div>
			</div><!-- footer -->
		</div><!-- page -->
	</body>
</html>
