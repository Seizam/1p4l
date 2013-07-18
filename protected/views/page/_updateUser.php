<?php
/* @var $this PageController */
/* @var $model User */
/* @var $form CActiveForm  */

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'user-form',
	'action' => array('user/update', 'id' => $model->id),
	'enableAjaxValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
	'htmlOptions' => array('class' => 'focus-zone')
		));
?>

<div class="row-fluid">
	<div class="span12">
		<?php echo $form->textField($model, 'name', array('class' => 'name span12', 'maxlength' => 64, 'placeholder' => 'My full name')); ?>
		<?php echo $form->error($model, 'name'); ?>
	</div>
</div>
<div class="row-fluid">
	<div class="span8">
		<?php echo $form->textArea($model, 'catch', array('class' => 'span12 catch', 'maxlength' => 180, 'rows' => 1, 'placeholder' => 'My short bio')); ?>
		<?php echo $form->error($model, 'catch'); ?>
	</div>
	<div class="span4">
	<?php
	$this->widget('bootstrap.widgets.TbButton', array(
		'buttonType' => 'submit',
		'label' => '<i class="icon-ok"></i> Save Headline',
		'encodeLabel' => false,
		'size' => 'medium',
		'htmlOptions' => array('class' => 'btn-block')
	));
	?>
	</div>
</div>
<?php $this->endWidget(); ?>