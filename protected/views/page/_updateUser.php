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
	<div class="span8">
		<?php echo $form->textField($model, 'name', array('class' => 'name span12', 'maxlength' => 64)); ?>
		<?php echo $form->error($model, 'name'); ?>
	</div>
	<?php
	$this->widget('bootstrap.widgets.TbButton', array(
		'buttonType' => 'submit',
		'label' => '<i class="icon-ok"></i> Save Headline',
		'encodeLabel' => false,
		'size' => 'medium',
		'htmlOptions' => array('class' => 'span4')
	));
	?>
</div>
<div class="row-fluid">
	<?php echo $form->textArea($model, 'catch', array('class' => 'span12 catch', 'maxlength' => 180, 'rows' => 1)); ?>
	<?php echo $form->error($model, 'catch'); ?>
</div>
<?php $this->endWidget(); ?>