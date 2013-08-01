<?php
/* @var $this LinkController */
/* @var $form TbActiveForm */
/* @var $model Link */

$this->pageTitle=Yii::app()->name . ' - Link';
?>
<h1><i class="icon-link"></i> Add a Link <small>Url, email, phone, gps position...</small></h1>
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

	<?php echo $form->textFieldRow($model,'link',array('maxlength'=>1024, 'class'=>'span12', 'hint' => '<b>e.g.</b> twitter.com/1p4l &bull; contact@seizam.com &bull; +33 (0) 970 448 200 &bull; skype:seizam')); ?>

	<?php echo $form->textFieldRow($model,'label',array('class'=>'span5','maxlength'=>45, 'hint' => 'Leave blank for automatic labelling')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=> '<i class="icon-link"></i> Add Link',
			'encodeLabel' => false,
			'size' => 'large',
		));
		
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'link',
			'type' => 'link',
			'label' => '<i class="icon-undo"></i> Back',
			'encodeLabel' => false,
			'size' => 'large',
			'url' => $this->getPageUpdateUrl()
		)) ?>
	</div>

<?php $this->endWidget(); ?>

</div>