<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head></head>
	<body>
		<p>
			<?php echo $form->body; ?>
		</p>
		<p>
			----<br />
			User: <?php echo $user == null ? 'NOT CONNECTED' : "{$user->name} (id={$user->id}, email={$user->email})"; ?><br />
			Contact infos: <?php echo "{$form->name} &lt;{$form->email}&gt;"; ?><br />
			Date: <?php echo gmdate("Y-m-d H:i:s") . ' GMT'; ?><br />
			Ip: <?php echo Yii::app()->request->userHostAddress; ?><br />
			Agent: <?php echo CHtml::encode(Yii::app()->request->userAgent); ?><br />
		</p>
	</body>
</html>
<?php 
$mail->from = ( $user == null ? array($form->email => $form->name) : array($user->email => $user->name) );
$mail->subject = "1P4L :: Contact :: " . $form->subject;
