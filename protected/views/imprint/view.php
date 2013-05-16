<?php
$this->breadcrumbs=array(
	'Imprints'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Imprint','url'=>array('index')),
	array('label'=>'Create Imprint','url'=>array('create')),
	array('label'=>'Update Imprint','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Imprint','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Imprint','url'=>array('admin')),
);
?>

<h1>View Imprint #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'imprint',
	),
)); ?>
