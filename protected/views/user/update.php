<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
?>

<h1>Update <small>Please fill out the following form</small></h1>
<hr/>
<div class="row-fluid">
	<?php
	$this->renderPartial('_updateForm', array(
		'model' => $model,
	));
	?>
</div>