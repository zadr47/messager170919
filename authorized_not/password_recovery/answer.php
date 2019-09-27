<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>password_recovery</title>
</head>
<body>
	<form action="/authorized_not/password_recovery/password_recovery.php" method="POST">

		<p>Ответьте на вопрос!</p>
		<p><b><?php echo $recovery->get_secret_question(); ?></b></p>
		<p><input type="text" name="answer" placeholder="enter answer"></p>
		<p><button name="do_recovery" value="answer">Ответить</button></p>
		<input type="hidden" name="login" value="<?php echo @$_REQUEST['login'] ?>">
	
	</form>
	
	<div id = "message">
	<?php if(!empty($message)):	
			
		echo "<p>$message</p>";

	endif;?>
</body>
</html>