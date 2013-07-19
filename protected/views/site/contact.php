<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $user User */
/* @var $form TbActiveForm */

$this->pageTitle = Yii::app()->name . ' - Contact Us';
?>

<h1><i class="icon-envelope"></i> Say Something <small>Make us Human</small></h1>
<hr/>
<div class="row-fluid">
	<?php
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id' => 'contact-form',
		'type' => 'horizontal',
		'enableClientValidation' => true,
		'clientOptions' => array(
			'validateOnSubmit' => true,
		),
	));
	
	$name = null;
	$email = null;
	if ($user != null) {
		$name = $user->name;
		$email = $user->email;
	}
	?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model, 'name', array('value' => $name)); ?>

	<?php echo $form->textFieldRow($model, 'email', array('value' => $email)); ?>

	<?php echo $form->textFieldRow($model, 'subject', array('size' => 60, 'maxlength' => 128)); ?>

	<?php echo $form->textAreaRow($model, 'body', array('rows' => 6, 'class' => 'span12')); ?>

	<?php if (CCaptcha::checkRequirements()): ?>
		<?php
		echo $form->captchaRow($model, 'verifyCode', array(
			'hint' => 'Please enter the letters as they are shown in the image above.<br/>Letters are not case-sensitive.',
		));
		?>
		<?php endif; ?>

	<div class="form-actions">
		<?php
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type' => 'primary',
			'label' => '<i class="icon-envelope"></i> Send',
			'encodeLabel' => false,
			'size' => 'large'
		));
		?>
	</div>

<?php $this->endWidget(); ?>

</div>