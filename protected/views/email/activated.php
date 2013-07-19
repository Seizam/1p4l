<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head></head>
	<body>
		<p>Hello <?php echo $user->name; ?>,</p>
		<p>Thanks! Your account on 1P4L is now active!</p>
		<p>Here is your short and easy imprint:</p>
		<p><b><?php
				$url = $this->createAbsoluteUrl('page/index', array('imprint'=> $imprint ) );
				echo CHtml::link(CHtml::encode($url), $url);
			?></b></p>
		<p>It points to your personal page, awaiting you to customize it.</p>
		<p>Don't wait any longer, <?php echo CHtml::link('log in', $this->createAbsoluteUrl('user/login')); ?> and update your page!</p>
		<p>See you soon!</p>
		<p>--<br />The 1P4L team</p>
		<p>PS: You CAN reply to this email :)</p>
	</body>
</html>
<?php $mail->subject = "Welcome!"; ?>