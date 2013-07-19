<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head></head>
	<body>
		<p>Hello <?php echo $user->name; ?>,</p>
		<p>One last step to complete signing up on 1P4L:</p>
		<p>Please <?php 
			$text = 'click this link to confirm your email address';
			$url = $this->createAbsoluteUrl('user/activate', array('token' => $token->token));
			echo CHtml::link(CHtml::encode($text), $url); ?>.</p>
		<p>Thanks!</p>
		<p>--<br />The 1P4L team</p>
		<p>PS: You CAN reply to this email :)</p>
	</body>
</html>
<?php $mail->subject = "Activate your account"; ?>