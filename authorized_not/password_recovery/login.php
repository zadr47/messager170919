<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>password_recovery</title>
</head>
<body>

	<form action="/authorized_not/password_recovery/password_recovery.php" method="POST">	

		<p>Введите ваш логин</p>
		<p><input type="text" name="login" placeholder="your login" value="<?php echo @$_REQUEST['login'] ?>"></p>
		<p><button name = "do_recovery" value = "login">Отправить</button></p>		

	</form>
	
	<div id = "message">
	<?php if(!empty($message)):	
			
		echo "<p>$message</p>";

	endif;?>
</body>
</html>