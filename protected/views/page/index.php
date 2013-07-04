<?php
/* @var $this PageController */
/* @var $model Imprint */

$this->layoutTitle = CHtml::link(SHORT_BASE_URL . '/' . $model->imprint, array('page/index', 'imprint' => $model->imprint));
$this->pageTitle = $model->user->name . ' - ' . SHORT_BASE_URL . '/' . $model->imprint;

if ($model->user->id == Yii::app()->user->id) {
	$this->menu[] = array('label' => '<i class="icon-pencil"></i> Edit',
		'url' => array('page/update',
			'id' => $model->user->id),
		'linkOptions' => array('class' => 'front')
	);
}
?>
<div class="row-fluid">
	<div class="span4">
		<?php
		$this->widget('ext.yii-gravatar.YiiGravatar', array(
			'email' => $model->user->email,
			'size' => 228,
			'defaultImage' => 'mm',
			'secure' => true,
			'rating' => 'g',
			'emailHashed' => false,
			'htmlOptions' => array(
				'alt' => 'Gravatar of ' . $model->user->name,
				'title' => 'Gravatar of ' . $model->user->name,
				'class' => 'img-rounded gravatar'
			)
		));
		?>
	</div>
	<div class="span8">
		<h1 class="name"><?php echo $model->user->name ?></h1>
		<h4 class="catch"><?php echo $model->user->catch ?></h4>
		<div class="links">
			<div class="row-fluid">
				<?php
				foreach ($model->user->links as $link) {
					//if ($first) echo '<div class="row-fluid">';
					$this->widget('application.views.widgets.LinkDiv', array(
						'linkTemplate' => LinkTemplate::newFromLink($link)
					));
				}
				?>
			</div>
		</div>
	</div>
</div>

