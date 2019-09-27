<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>password_recovery</title>
</head>
<body>
	<form action="/authorized_not/password_recovery/password_recovery.php" method="POST">

			<p>Придумайте новый пароль.</p>
			<p>Заполните поля.</p>
			<p>Пароли должны совпадать.</p>
			<p>Пароль должен содержать от 3 до 16 символов</p>

			<p><input type="text" name="password_1" placeholder="first password" value="<?php echo @$_REQUEST['password_1'] ?>"></p>
			<p><input type="text" name="password_2" placeholder="second password"></p>
			<p><button name="do_recovery" value="password">Установить</button></p>
			<input type="hidden" name="login" value="<?php echo @$_REQUEST['login'] ?>">

	</form>

	<div id = "message">
	<?php if(!empty($message)):	
			
		echo "<p>$message</p>";

	endif;?>
</body>
</html>