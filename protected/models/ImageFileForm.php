<?php

class ImageFileForm extends CFormModel {

	public $image;

	public function rules() {
		return array(
			array('image', 'file', 'mimeTypes'=>'image/jpeg, image/pjpeg, image/png, image/x-png', 'types' => 'jpg, jpeg, png'),
		);
	}

}