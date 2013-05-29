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

<?php $this->widget('bootstrap.widgets.TbNavbar',array(
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
                array('label'=>'Home', 'url'=>array('/site/index')),
                array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
                array('label'=>'Contact', 'url'=>array('/site/contact')),
				array('label'=>'Create account', 'url'=>array('/user/create'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Login', 'url'=>array('/user/login'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/user/logout'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'User admin', 'url'=>array('/user/index'), 'visible' => Yii::app()->user->isAdmin),
            ),
        ),
    ),
)); ?>

<div class="container" id="page">

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php
		$alertConfig = array('block' => true, 'fade' => true, 'closeText' => '&times;');
		$this->widget('bootstrap.widgets.TbAlert', array(
			'block' => true, // display a larger alert block?
			'fade' => true, // use transitions?
			'closeText' => '&times;', // close link text - if set to false, no close link is displayed
			'alerts' => array( // configurations per alert type (success, info, warning, error or danger)
				'success'	=> $alertConfig,
				'info'		=> $alertConfig,
				'warning'	=> $alertConfig,
				'error'		=> $alertConfig,
				'danger'	=> $alertConfig,
			),
		) );
	?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
