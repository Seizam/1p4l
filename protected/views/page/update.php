<?php
/* @var $this PageController */
/* @var $model Imprint */

$this->layoutTitle = CHtml::link(SHORT_BASE_URL, array('site/index'))
		. CHtml::link('/' . $model->imprint, array('page/index', 'imprint' => $model->imprint))
		. CHtml::link('/' . $this->action->id, array('page/update', 'imprint' => $model->imprint));
$this->pageTitle = 'Update - ' . SHORT_BASE_URL . '/' . $model->imprint;
unset($this->menu['mypage']);
$this->menu['view'] = array('label' => '<i class="icon-file"></i> View',
	'url' => array('page/index',
		'imprint' => $model->imprint),
	'linkOptions' => array('class' => 'front')
);
?>
<div class="row-fluid">
	<div class="span4 focus-zone">
		<?php
		// The portrait image
		if ($portrait == null) {
			$image = $this->widget('ext.yii-gravatar.YiiGravatar', array(
				'email' => $model->user->email,
				'size' => 228,
				'defaultImage' => 'mm',
				'secure' => true,
				'rating' => 'g',
				'emailHashed' => false,
				'htmlOptions' => array(
					'alt' => 'Gravatar of ' . $model->user->name,
					'class' => 'img-rounded portrait'
				)
			), true);
			$url = 'http://gravatar.com';
			$title = 'Setup your portrait through Gravatar.com';
		} else {
			$image = CHtml::image($portrait, 'Portrait of ' . $model->user->name, array('class' => 'img-rounded portrait'));
			$url = array('user/uploadPortrait', 'id' => $model->user->id);
			$title = 'ReUpload your portrait';
		}

		echo CHtml::link($image, $url, array('title' => $title));
		?>
		<div class="row-fluid portrait-control">
			<?php
			// The buttons
			if ($portrait == null) {
				$this->widget('bootstrap.widgets.TbButton', array(
					'buttonType' => 'link',
					'type' => 'primary',
					'url' => array('user/uploadPortrait', 'id' => $model->user->id),
					'size' => 'medium',
					'encodeLabel' => false,
					'label' => '<i class="icon-upload"></i> Upload',
					'htmlOptions' => array('class' => 'span6')
				));
				$this->widget('bootstrap.widgets.TbButton', array(
					'buttonType' => 'link',
					'url' => 'http://www.gravatar.com',
					'size' => 'medium',
					'encodeLabel' => false,
					'label' => '<i class="icon-globe"></i> Gravatar',
					'htmlOptions' => array('class' => 'span6')
				));
			} else {
				$this->widget('bootstrap.widgets.TbButton', array(
					'buttonType' => 'link',
					'type' => 'primary',
					'url' => array('user/uploadPortrait', 'id' => $model->user->id),
					'size' => 'medium',
					'encodeLabel' => false,
					'label' => '<i class="icon-upload"></i> ReUpload',
					'htmlOptions' => array('class' => 'span6')
				));
				$this->widget('bootstrap.widgets.TbButton', array(
					'buttonType' => 'link',
					'type' => 'danger',
					'url' => array('user/deletePortrait', 'id' => $model->user->id),
					'size' => 'medium',
					'encodeLabel' => false,
					'label' => '<i class="icon-remove"></i> Delete',
					'htmlOptions' => array('class' => 'span6')
				));
			}
			?>
		</div>

	</div>
	<div class="span8">
		<?php
		$this->renderPartial('_updateUser', array(
			'model' => $model->user,
		));
		?>
		<div class="links links-edit">
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

