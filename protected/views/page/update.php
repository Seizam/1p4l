<?php
/* @var $this PageController */
/* @var $model Imprint */

$this->layoutTitle = CHtml::link(SHORT_BASE_URL, array('site/index'))
		.CHtml::link('/' . $model->imprint, array('page/index', 'imprint' => $model->imprint))
		.CHtml::link('/' . $this->action->id , array('page/update', 'imprint' => $model->imprint));
$this->pageTitle = 'Update - ' . SHORT_BASE_URL . '/' . $model->imprint;
unset($this->menu['mypage']);
$this->menu['view'] = array('label' => '<i class="icon-eye-open"></i> View',
	'url' => array('page/index',
		'imprint' => $model->imprint),
	'linkOptions' => array('class' => 'front')
);
?>
<div class="row-fluid">
	<div class="span4">

	<?php
		if ($portrait == null) {
	?>

		<a href="http://www.gravatar.com">
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
		</a>
		<p class="gravatar-notice">
			<?php echo CHtml::link('Upload your portrait', array('user/uploadPortrait', 'id' => $model->user->id)) ?>
			or change it on <?php echo CHtml::link('gravatar.com', 'http://www.gravatar.com') ?>
		</p>

	<?php
		} else {
	?>

		<img alt="Portrait of <?php echo $model->user->name ?>" title="Portrait of <?php echo $model->user->name ?>" class="img-rounded" src="<?php echo $portrait ?>">
		<p>
			<?php echo CHtml::link('Reupload a new portrait', array('user/uploadPortrait', 'id' => $model->user->id)) ?>
			or <?php echo CHtml::link('return to your Gravatar', array('user/deletePortrait', 'id' => $model->user->id)) ?>
		</p>

	<?php
		}
	?>

	</div>
	<div class="span8">
		<?php
		$this->renderPartial('_updateUser', array(
			'model' => $model->user,
		));
		?>
		<div class="links">
			<div class="row-fluid">
				<?php
				foreach ($model->user->links as $link) {
					$this->widget('application.views.widgets.LinkDivUpdate', array(
						'linkTemplate' => LinkTemplate::newFromLink($link)
					));
				}

				$content = "<i class=icon-plus-sign></i>\n";
				$content .= "<div class=\"caption\">Add Link</div>\n";
				$htmlOptions = array('class' => "link-a span6 large link-add");

				echo CHtml::link($content, array('link/create', 'id' => $model->user->id), $htmlOptions);
				?>

			</div>
		</div>
	</div>
</div>

