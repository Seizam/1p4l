<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm  */
?>

<h1><i class="icon-upload"></i> Upload <small>You Look Great !</small></h1>
<hr/>
<div class="row-fluid">

	<?php
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id' => 'user-upload-form',
		'type' => 'horizontal',
		'enableAjaxValidation' => false,
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
			)
	);
	?>

	<?php /* error already displayed near each field */ echo $form->errorSummary($model); ?>

	<?php echo $form->fileFieldRow($model, 'image', array('hint'=>'Best format is 228px wide square JPEG. ')); ?>

	<div class="form-actions">
		<?php
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type' => 'primary',
			'label' => '<i class="icon-upload"></i> Upload',
			'encodeLabel' => false,
			'size' => 'large'
		));

		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'link',
			'type' => 'link',
			'label' => '<i class="icon-undo"></i> Back',
			'encodeLabel' => false,
			'size' => 'large',
			'url' => array('page/update', 'imprint' => $this->getUserImprint())
		))
		?> 
	</div>

	<?php $this->endWidget(); ?>

</div>