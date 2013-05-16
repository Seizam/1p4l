<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->passwordFieldRow($model,'password',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'created',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'modified',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'last_login',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'last_login_ip',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'catch',array('class'=>'span5','maxlength'=>180)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
