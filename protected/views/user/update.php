<?php
$this->breadcrumbs=array(
	'Users' => array('index'),
	"[{$model->id}]{$model->name}" => array('view', 'id' => $model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'View User','url'=>array('view','id'=>$model->id)),
	array('label' => 'Delete User', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
);
?>

<h1>Update User <?php echo $model->id; ?></h1>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php /* error already displayed near each field */ echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'catch',array('class'=>'span5','maxlength'=>180)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Update',
		)); ?>
	</div>

<?php $this->endWidget(); ?>