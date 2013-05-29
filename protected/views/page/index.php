<h1>1PFL.com/<?php echo $model->imprint ?></h1>

<h2>User</h2>
<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'user.email',
		'user.created',
		'user.modified',
		'user.last_login',
		'user.last_login_ip',
		'user.name',
		'user.catch',
	),
));
?>

<h2>Links</h2>
<?php
foreach ($model->user->links as $link) {
	$this->widget('application.views.widgets.LinkButton', array(
		'link' => $link
	));
}
?>