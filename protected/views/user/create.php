<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form TbActiveForm */

$this->pageTitle = Yii::app()->name . ' - Signup';
?>
<h1><i class="icon-bolt"></i> SignUp <small>Fast, Free & Formidable !</small></h1>
<hr/>
<div class="row-fluid">

	<?php
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id' => 'user-create-form',
		'type' => 'horizontal',
		'enableClientValidation' => true,
		'clientOptions' => array(
			'validateOnSubmit' => true,
		),
	));
	?>

	<?php echo $form->textFieldRow($model, 'email', array('class' => 'span5', 'maxlength' => 45)); ?>

	<?php echo $form->passwordFieldRow($model, 'password', array('class' => 'span5', 'maxlength' => 64)); ?>

	<?php echo $form->passwordFieldRow($model, 'passwordRepeat', array('class' => 'span5', 'maxlength' => 64)); ?>

	<?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 45)); ?>

	<?php /* echo $form->textFieldRow($model,'catch',array('class'=>'span12','maxlength'=>180)); */ ?>

	<?php if (CCaptcha::checkRequirements()): ?>
		<?php
		echo $form->captchaRow($model, 'verifyCode', array(
			'hint' => 'Please enter the letters as they are shown in the image above.<br/>Letters are not case-sensitive.',
		));
		?>
	<?php endif; ?>

	<?php echo $form->checkBoxRow($model, 'acceptConditions'); ?>

	<div class="form-actions">
		<?php
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type' => 'primary',
			'size' => 'large',
			'encodeLabel' => false,
			'label' => '<i class="icon-bolt"></i> Create',
		));
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'reset',
			'type' => 'link',
			'size' => 'large',
			'encodeLabel' => false,
			'label' => '<i class="icon-undo"></i> Reset'
		));
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'link',
			'type' => 'link',
			'url' => array('user/login'),
			'size' => 'large',
			'encodeLabel' => false,
			'label' => '<i class="icon-signin"></i> LogIn'
		));
		?>
	</div>

	<?php $this->endWidget(); ?>
</div>