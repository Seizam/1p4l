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

	<body>
		<div class="container" id="page">
			<div class="row-fluid">
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
			<div id="mainframe">
				<?php echo $content; ?>
			</div>
			<div class="row-fluid" id="footer">
				<p class="pull-right"><?php echo Yii::powered(); ?></p>
				<p><a href="http://www.onepageforlife.com">1 Page 4 Life</a> is provided by <a href="http://atelier.seizam.com">Seizam</a>.</p>
			</div><!-- footer -->
		</div><!-- page -->
	</body>
</html>
