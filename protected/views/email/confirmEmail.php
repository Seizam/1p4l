<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head></head>
	<body>
		<p>Dear <?php echo $user->name; ?>,</p>
		<p>To complete your account creation on 1P4L, please visit this page: <?php 
			$href = $this->createAbsoluteUrl('user/confirmEmail', array('token' => $token->token));
			echo CHtml::link(CHtml::encode($href), $href); ?></p>
		<p>----<br />We look forward to serving you!<br />The 1P4L team</p>
	</body>
</html>
<?php $mail->subject = "1P4L :: Account activation"; ?>