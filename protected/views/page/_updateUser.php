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
		));
?>

<div class="row-fluid">
	<?php echo $form->textField($model, 'name', array('class' => 'span12 name', 'maxlength' => 64)); ?>
	<?php echo $form->error($model, 'name'); ?>
</div>
<div class="row-fluid">
	<?php echo $form->textArea($model, 'catch', array('class' => 'span12 catch', 'maxlength' => 180, 'rows' => 1)); ?>
	<?php echo $form->error($model, 'catch'); ?>
</div>
<div class="row-fluid">
		<?php
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type' => 'primary',
			'label' => '<i class="icon-ok"></i> Update',
			'encodeLabel' => false,
			'size' => 'small',
			'htmlOptions' => array('class'=>'span3 offset6')
		));

		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'reset',
			'type' => 'button',
			'label' => '<i class="icon-undo"></i> Reset',
			'encodeLabel' => false,
			'size' => 'small',
			'htmlOptions' => array('class'=>'span3')
		))
		?> 
</div>
<?php $this->endWidget(); ?>