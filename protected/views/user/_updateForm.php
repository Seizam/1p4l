<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'user-update-form',
	'type' => 'horizontal',
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
		));
?>

<?php /* error already displayed near each field */ echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 45)); ?>

	<?php echo $form->textFieldRow($model, 'catch', array('class' => 'span12', 'maxlength' => 180)); ?>

<div class="form-actions">
	<?php
	$this->widget('bootstrap.widgets.TbButton', array(
		'buttonType' => 'submit',
		'type' => 'primary',
		'label' => 'Update',
		'size' => 'large'
	));

	$this->widget('bootstrap.widgets.TbButton', array(
		'buttonType' => 'link',
		'type' => 'link',
		'label' => 'Back',
		'size' => 'large',
		'url' => $this->createUrl('page/index')
	))
	?> 
</div>

<?php $this->endWidget(); ?>