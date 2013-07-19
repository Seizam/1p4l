<?php
/* @var $this PageController */
/* @var $model Imprint */
/* @var $portrait string */
/* @var $QRCodeUrl string */

$this->layoutTitle = CHtml::link(SHORT_BASE_URL, array('site/index')) . CHtml::link('/' . $model->imprint, array('page/index', 'imprint' => $model->imprint));
$this->pageTitle = $model->user->name . ' - ' . SHORT_BASE_URL . '/' . $model->imprint;

if ($model->user->id == Yii::app()->user->id) {
	unset($this->menu['mypage']);
	$this->menu[] = array('label' => '<i class="icon-pencil"></i> Update',
		'url' => array('page/update',
			'imprint' => $model->imprint),
		'linkOptions' => array('class' => 'front')
	);
}
?>
<div class="row-fluid">
	<div class="span4 portrait">
		<?php
		if ($portrait == null) {
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
					'class' => 'img-rounded'
				)
			));
		} else {
			echo CHtml::image($portrait, 'Portrait of ' . $model->user->name, array('class' => 'img-rounded'));
		}
		?>
		<div class="row-fluid carrousel">
		<?php
			echo CHtml::link(CHtml::image($QRCodeUrl), $QRCodeUrl, array('class'=>'qrcode span4'));
		?>
		</div>

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

