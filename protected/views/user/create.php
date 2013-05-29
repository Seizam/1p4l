<h1>Create Account</h1>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php // /* error already displayed near each field */ echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->passwordFieldRow($model,'password',array('class'=>'span5','maxlength'=>64)); ?>

	<?php echo $form->passwordFieldRow($model,'passwordRepeat',array('class'=>'span5','maxlength'=>64)); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'catch',array('class'=>'span5','maxlength'=>180)); ?>
    
	<?php if(CCaptcha::checkRequirements()): ?>
		<?php echo $form->captchaRow($model,'verifyCode',array(
            'hint'=>'Please enter the letters as they are shown in the image above.<br/>Letters are not case-sensitive.',
        )); ?>
	<?php endif; ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Create',
		)); ?>
	</div>

<?php $this->endWidget(); ?>