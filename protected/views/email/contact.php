<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head></head>
	<body>
		<p>
			<?php echo $model->body; ?>
		</p>
		<p>
			----<br />
			From: <?php echo "{$model->name} &lt;{$model->email}&gt;"; ?><br />
			Date: <?php echo gmdate("Y-m-d H:i:s") . ' GMT'; ?><br />
			Ip: <?php echo Yii::app()->request->userHostAddress; ?><br />
			Agent: <?php echo CHtml::encode(Yii::app()->request->userAgent); ?><br />
		</p>
	</body>
</html>
<?php 
$mail->from = array( $model->email => $model->name );
$mail->subject = "1P4L :: Contact :: " . $model->subject;
