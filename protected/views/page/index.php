<div class="row-fluid">
	<div class="span3">
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
	<div class="span9">
		<h1 class="name"><?php echo $model->user->name ?></h1>
		<h4 class="catch"><?php echo $model->user->catch ?></h4>
		<hr/>
		<div class="row-fluid links">
		<?php
			$first = true;
			foreach ($model->user->links as $link) {
				if ($first) echo '<div class="row-fluid">';
				$this->widget('application.views.widgets.LinkDiv', array(
					'linkTemplate' => LinkTemplate::newFromLink($link)
				));
				if (!$first) echo '</div>';
				$first = !$first;
			}
			if (!$first) echo '</div>'
		?>
		</div>
	</div>
</div>

