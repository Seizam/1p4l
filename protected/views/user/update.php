<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm  */
?>

<h1>Update <small>Please fill out the following form</small></h1>
<hr/>
<div class="row-fluid">
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

	<?php echo $form->textAreaRow($model, 'catch', array('class' => 'span12', 'maxlength' => 180, 'rows'=>1)); ?>

	<div class="form-actions">
		<?php
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type' => 'primary',
			'label' => '<i class="icon-ok"></i> Update',
			'encodeLabel' => false,
			'size' => 'large'
		));

		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'link',
			'type' => 'link',
			'label' => '<i class="icon-undo"></i> Back',
			'encodeLabel' => false,
			'size' => 'large',
			'url' => $this->createUrl('page/update')
		))
		?> 
	</div>

	<?php $this->endWidget(); ?>
</div>