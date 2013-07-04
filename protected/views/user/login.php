<?php
/* @var $this UserController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
?>

<h1>Login <small>Please fill out the following form</small></h1>
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
			'label' => 'Login',
		));
		?>
	</div>

<?php $this->endWidget(); ?>

</div>
