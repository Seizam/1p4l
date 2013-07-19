<?php

include('phpqrcode/qrlib.php');

class QRCodeGenerator extends CComponent {

	/**
	 * 
	 * @param string $data Data to be stored in the QR code
	 * @param string $filePath An absolute path to container directory of the PNG file
	 * @param string $filename The PNG filename (default to "{$data}.png")
	 * @param char $errorCorrectionLevel Accepts L,M,Q,H (default to 'M')
	 * @param int $matrixPointSize 1 <= $matrixPointSize <= 10 (default to 10)
	 * @return string The created filename
	 */
	public static function save($data, $filePath, $filename = null, $errorCorrectionLevel = 'M', $matrixPointSize = 10, $margin = 10) {

		if (is_null($data)) {
			throw new CException(Yii::t(get_class($this), 'Data must not be empty'));
		}

		if (is_null($filename)) {
			$filename = $data . '.png';
		}

		if (!is_dir($filePath)) {
			throw new CHttpException(500, "{$filePath} does not exists.");
		} else if (!is_writable($filePath)) {
			throw new CHttpException(500, "{$filePath} is not writable.");
		}

		$filePath = $filePath . '/' . $filename;

		if (!in_array($errorCorrectionLevel, array('L', 'M', 'Q', 'H'))) {
			throw new CException(Yii::t(get_class($this), 'Error Correction Level only accepts L,M,Q,H'));
		}

		$matrixPointSize = min(max((int) $matrixPointSize, 1), 10);
		
		$matrixPointSize = min(max((int) $margin, 1), 10);

		QRcode::png($data, $filePath, $errorCorrectionLevel, $matrixPointSize, $margin);

		return $filename;
	}

}
