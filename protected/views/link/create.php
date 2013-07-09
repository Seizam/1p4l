<?php
/* @var $this SiteController */
/* @var $form TbActiveForm */

$this->pageTitle=Yii::app()->name . ' - Link';
?>
<h1>Add Link <small>Please fill out the following form</small></h1>
<hr/>
<div class="row-fluid">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'link-create-form',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'link',array('maxlength'=>1024, 'class'=>'span12')); ?>

	<?php echo $form->textFieldRow($model,'label',array('class'=>'span5','maxlength'=>45)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=> '<i class="icon-ok"></i> Create',
			'encodeLabel' => false,
		));
		
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'link',
			'type' => 'link',
			'label' => '<i class="icon-undo"></i> Back',
			'encodeLabel' => false,
			'size' => 'large',
			'url' => $this->createUrl('page/update')
		)) ?>
	</div>

<?php $this->endWidget(); ?>

</div>