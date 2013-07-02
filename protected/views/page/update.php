<?php
$this->layoutTitle = '<b>Update</b> - ' . CHtml::link(SHORT_BASE_URL . '/' . $model->imprint, array('page/index', 'imprint' => $model->imprint));
$this->pageTitle = 'Update - ' . SHORT_BASE_URL . '/' . $model->imprint;
?>
<div class="row-fluid">
	<div class="span4">
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
		<p class="gravatar-notice">Change your portrait on <?php echo CHtml::link('gravatar.com', 'http://www.gravatar.com') ?></p>
	</div>
	<div class="span8">
		<?php echo CHtml::link('<i class="icon-pencil"></i>', array('user/update', 'id' => $model->user->id), array('class' => 'pull-right btn-update')); ?>
		<h1 class="name"><?php echo $model->user->name ?></h1>
		<h4 class="catch">
			<?php echo $model->user->catch ?>
		</h4>
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

