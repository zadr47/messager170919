<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>check_in</title>
</head>
<body>
	<form action="/authorized_not/check_in/check_in.php" method="POST">
		<input type="text" name="login" placeholder="login" value="<?php echo @$_REQUEST['login'] ?>"><br />
		<input type="text" name="password_1" placeholder="password" value="<?php echo @$_REQUEST['password_1'] ?>"><br />
		<input type="text" name="password_2" placeholder="password"><br />
		<input type="submit" name="do_check_in" value="check_in"><br />
	</form>
	<div id = "message">
	<?php if(!empty($message)):	
			
		echo $message;

	endif;?>
	</div>
</body>
</html>