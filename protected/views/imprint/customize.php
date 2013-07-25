<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form TbActiveForm */

$this->pageTitle = Yii::app()->name . ' - Customize imprint';
?>
<h1>Imprint <small>Please fill out the following form</small></h1>
<hr/>
<div class="row-fluid">
	<?php
		$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'id' => 'link-form',
			'enableAjaxValidation' => false,
		));
	?>

	<?php echo $form->errorSummary($new); ?>

	<?php echo $form->textFieldRow($new, 'imprint', array('class' => 'span5', 'maxlength' => 45)); ?>

	<?php echo $form->checkBoxRow($new, 'freeOldImprint'); ?>

	<div class="form-actions">
		<?php
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type' => 'primary',
			'label' => 'Create and assign to user',
		));
		?>
	</div>

	<?php $this->endWidget(); ?>

</div>