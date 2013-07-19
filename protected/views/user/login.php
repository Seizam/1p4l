<?php
/* @var $this UserController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
?>

<h1><i class="icon-signin"></i> LogIn <small>Glad to have you back !</small></h1>
<hr/>
<div class="row-fluid">

	<?php
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id' => 'login-form',
		'type' => 'horizontal',
		'enableClientValidation' => true,
		'clientOptions' => array(
			'validateOnSubmit' => true,
		),
	));
	?>
	<?php echo $form->textFieldRow($model, 'email'); ?>

	<?php echo $form->passwordFieldRow($model, 'password'); ?>

	<?php echo $form->checkBoxRow($model, 'rememberMe'); ?>

	<div class="form-actions">
		<?php
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type' => 'primary',
			'size' => 'large',
			'encodeLabel' => false,
			'label' => '<i class="icon-signin"></i> LogIn',
		));
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'link',
			'type' => 'link',
			'url' => array('user/create'),
			'size' => 'large',
			'encodeLabel' => false,
			'label' => '<i class="icon-bolt"></i> SignUp'
		));
		?>
	</div>

	<?php $this->endWidget(); ?>

</div>
