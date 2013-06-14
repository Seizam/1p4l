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
				echo "<div class=\"span6 div-link div-link-large div-link-add\">\n";
				echo CHtml::link('<i class=icon-plus-sign></i><div>New Link</div>', array('link/create', 'id' => $model->user->id));
				echo "</div>\n"
				?>

			</div>
		</div>
	</div>
</div>

