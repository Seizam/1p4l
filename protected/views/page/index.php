<?php
/* @var $this PageController */
/* @var $model User */

$this->layoutTitle = CHtml::link(SHORT_BASE_URL, array('site/index')) . CHtml::link('/' . $model->mainImprint->imprint, array('page/index', 'imprint' => $model->mainImprint->imprint));
$this->pageTitle = $model->name . ' - ' . SHORT_BASE_URL . '/' . $model->mainImprint->imprint;

if ($model->id == Yii::app()->user->id) {
	unset($this->menu['mypage']);
	$this->menu[] = array('label' => '<i class="icon-pencil"></i> Update',
		'url' => array('page/update',
			'imprint' => $model->mainImprint->imprint),
		'linkOptions' => array('class' => 'front')
	);
}
?>
<div class="row-fluid">
	<div class="span4 left-column">
		
		<?php
		// The portrait image
		if ($model->portrait->exists()) {
			$image = CHtml::image($model->portrait->url, 'Portrait of ' . $model->name, array('class' => 'img-rounded portrait'));
		} else {
			$image = $this->widget('ext.yii-gravatar.YiiGravatar', array(
				'email' => $model->email,
				'size' => 228,
				'defaultImage' => 'mm',
				'secure' => true,
				'rating' => 'g',
				'emailHashed' => false,
				'htmlOptions' => array(
					'alt' => 'Gravatar of ' . $model->name,
					'class' => 'img-rounded portrait'
				)
			), true);
		}

		echo $image;
		?>
		<div class="row-fluid share-control">
			<div class="span4">
				<?php
				echo CHtml::link('/' . strtoupper($model->mainImprint->imprint), array('page/index', 'imprint' => $model->mainImprint->imprint), array('class' => 'imprint-link', 'rel' => 'tooltip', 'title' => 'My Imprint'));
				?>
			</div>
			<div class="span4">
				<?php echo CHtml::link('<i class="icon-share-sign"></i> Share', 'http://www.addthis.com/bookmark.php?v=300&amp;pubid=ra-4fdafa43072e511d', array('class' => 'addthis_button')); ?>
				<script type="text/javascript">var addthis_config = {"data_track_addressbar": false};</script>
				<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4fdafa43072e511d"></script>
			</div>
			<div class="span4">
				<?php echo CHtml::link('<i class="icon-qrcode"></i> QRCode', $model->qRCode->url, array('class' => 'qrcode-link', 'rel' => 'tooltip', 'title' => 'My QRCode', 'data-toggle' => 'modal','data-target' => '#QRCodeModal')); ?>
			</div>
		</div>

	</div>
	<div class="span8">
		<h1 class="name"><?php echo $model->name ?></h1>
		<h4 class="catch"><?php echo $model->catch ?></h4>
		<div class="links">
			<div class="row-fluid">
				<?php
				foreach ($model->links as $link) {
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

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'QRCodeModal')); ?>
<div class="modal-header">
	<a class="close" data-dismiss="modal">&times;</a>
	<h4><?php echo $model->name ?></h4>
</div>

<div class="modal-body">
	<?php echo CHtml::image($model->qRCode->url, 'QRCode of ' . $model->mainImprint->imprint, array('class' => 'QRCode pull-right')); ?>
	<p>People can flash this image to come here.</p>
	<p>Write it, cut it, paste it, save it, load it, check it, quick reflash it.</p>
</div>

<div class="modal-footer">
	<?php
	$this->widget('bootstrap.widgets.TbButton', array(
		'label' => 'Close',
		'url' => '#',
		'htmlOptions' => array('data-dismiss' => 'modal'),
	));
	?>
</div>
<?php $this->endWidget(); ?>

