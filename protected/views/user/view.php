<?php
$this->breadcrumbs = array(
	'Users' => array('index'),
	"[{$model->id}]{$model->name}",
);

$this->menu = array(
	array('label' => 'Update User', 'url' => array('update', 'id' => $model->id)),
	array('label' => 'Delete User', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
);
?>

<h1>View User #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'status',
		'email',
		/* 'password', */
		'created',
		'modified',
		'last_login',
		'last_login_ip',
		'name',
		'catch',
	),
)); ?>
