<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>password_recovery</title>
</head>
<body>
	<form action="/authorized_not/password_recovery.php" method="POST">
		<?php switch ($value) {
			case 'login': ?>

				<p>Введите ваш логин</p>
				<p><input type="text" name="login" placeholder="your login" value="<?php echo @$_REQUEST['login'] ?>"></p>
				<p><input type="submit" name="do_login" valee="отправить"></p>

				<?php break;
			case 'answer': ?>

				<p>Ответьте на вопрос!</p>
				<p><b><?php echo $question; ?></b></p>
				<p><input type="text" name="answer" placeholder="enter answer"></p>
				<p><input type="submit" name="do_answer" value="ответить"></p>
				<input type="hidden" name="login" value="<?php echo @$data['login'] ?>">


				<?php break; 
			case 'password': ?>

				<p>Придумайте новый пароль.</p>
				<p><input type="text" name="password_1" placeholder="first password" value="<?php echo @$_REQUEST['password_1'] ?>"></p>
				<p><input type="text" name="password_2" placeholder="second password"></p>
				<p><input type="submit" name="do_password" value="установить"></p>
				<input type="hidden" name="login" value="<?php echo @$data['login'] ?>">

				<?php break; 
		}?>			
	</form>
	<div id = "message">
	<?php if(!empty($message)):	
			
		echo "<p>$message</p>";

	endif;?>
</body>
</html>