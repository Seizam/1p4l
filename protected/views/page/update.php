<?php
/* @var $this PageController */
/* @var $model User */

$this->layoutTitle = CHtml::link(SHORT_BASE_URL, array('site/index'))
		. CHtml::link('/' . $model->mainImprint->imprint, $this->getPageIndexUrl($model))
		. CHtml::link('/' . $this->action->id, $this->getPageUpdateUrl($model));
$this->pageTitle = 'Update - ' . SHORT_BASE_URL . '/' . $model->mainImprint->imprint;
unset($this->menu['mypage']);
$this->menu['view'] = array('label' => '<i class="icon-file"></i> View',
	'url' => array('page/index',
		'imprint' => $model->mainImprint->imprint),
	'linkOptions' => array('class' => 'front')
);
?>
<div class="row-fluid">
	<div class="span4 focus-zone left-column">
		<?php
		// The portrait image
		if ($model->portrait->exists()) {
			$image = CHtml::image($model->portrait->url, 'Portrait of ' . $model->name, array('class' => 'img-rounded portrait'));
			$url = array('portrait/upload');
			$title = 'ReUpload your portrait';
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
			$url = 'http://gravatar.com';
			$title = 'Setup your portrait through Gravatar.com';
		} 

		echo CHtml::link($image, $url, array('title' => $title));
		?>
		<div class="row-fluid portrait-control">
			<?php
			// The buttons
			$buttons = array();
			if ($model->portrait->exists()) {
				$buttons[] = $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType' => 'link',
					'type' => 'primary',
					'url' => array('portrait/upload'),
					'size' => 'medium',
					'encodeLabel' => false,
					'label' => '<i class="icon-upload"></i> ReUpload',
					'htmlOptions' => array('class' => 'span6')
				), true);
				$buttons[] = $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType' => 'link',
					'type' => 'danger',
					'url' => array('portrait/delete'),
					'size' => 'medium',
					'encodeLabel' => false,
					'label' => '<i class="icon-remove"></i> Delete',
					'htmlOptions' => array('class' => 'span6')
				), true);
			} else {
				$buttons[] = $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType' => 'link',
					'type' => 'primary',
					'url' => array('portrait/upload'),
					'size' => 'medium',
					'encodeLabel' => false,
					'label' => '<i class="icon-upload"></i> Upload',
					'htmlOptions' => array('class' => 'span6')
				), true);
				$buttons[] = $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType' => 'link',
					'url' => 'http://www.gravatar.com',
					'size' => 'medium',
					'encodeLabel' => false,
					'label' => '<i class="icon-globe"></i> Gravatar',
					'htmlOptions' => array('class' => 'span6')
				), true);
			} 

			foreach ($buttons as $button) {
				echo $button;
			}
			?>
		</div>

	</div>
	<div class="span8">
		<?php
		$this->renderPartial('_updateUser', array(
			'model' => $model,
		));
		?>
		<div class="links links-edit">
			<div class="row-fluid">
				<?php
				foreach ($model->links as $link) {
					$this->widget('application.views.widgets.LinkDivUpdate', array(
						'linkTemplate' => LinkTemplate::newFromLink($link)
					));
				}

				$content = "<i class=icon-plus-sign></i>\n";
				$content .= "<div class=\"caption\">Add Link</div>\n";
				$htmlOptions = array('class' => "link-a span6 large link-add");

				echo CHtml::link($content, array('link/create'), $htmlOptions);
				?>

			</div>
		</div>
	</div>
</div>

