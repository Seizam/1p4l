<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head></head>
	<body>
		<p>Dear <?php echo $user->name; ?>,</p>
		<p>To complete your account creation on 1 Page 4 Life, <?php 
			$text = 'please visit this page to confirm your email address';
			$url = $this->createAbsoluteUrl('user/activate', array('token' => $token->token));
			echo CHtml::link(CHtml::encode($text), $url); ?>.</p>
		<p>----<br />We look forward to serving you!<br />The 1P4L team</p>
	</body>
</html>
<?php $mail->subject = "1P4L :: Account activation"; ?>