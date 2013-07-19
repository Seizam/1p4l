<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head></head>
	<body>
		<p>Dear <?php echo $user->name; ?>,</p>
		<p>Congratulation! Your account on 1 Page 4 Life is now active!</p>
		<p>
			We have given you a short and easy address:<br />
			&nbsp;&nbsp;&nbsp;&nbsp;<?php
				$url = $this->createAbsoluteUrl('page/index', array('imprint'=> $imprint ) );
				echo CHtml::link(CHtml::encode($url), $url);
			?>
		</p>
		<p>It points to your personal page, awaiting for you to customise it.</p>
		<p>Don't wait, <?php echo CHtml::link('log in', $this->createAbsoluteUrl('user/login')); ?> and edit your page!</p>
		<p>----<br />We look forward to serving you!<br />The 1P4L team</p>
	</body>
</html>
<?php $mail->subject = "Welcome!"; ?>