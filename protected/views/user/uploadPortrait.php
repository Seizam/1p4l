<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm  */
?>

<h1>Upload your portrait <small>Please select your image file</small></h1>
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

	<?php
	echo $form->fileField($model, 'image');
	echo $form->error($model, 'image');
	?>

	<div class="form-actions">
		<?php
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type' => 'primary',
			'label' => '<i class="icon-ok"></i> Upload',
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