<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>log in</title>
</head>
<body>
	<div id = "message">
	<?php if(!empty($message)):	
			
		echo "<p>$message</p>";

	endif;?>
	<form action="log_in.php" method="POST">
		
		<input type="text" name="login" placeholder="login" value="<?php echo @$_REQUEST['login'] ?>"><br />
		<input type="password" name="password" placeholder="password"><br />
		<input type="submit" name="do_log_in" value="log_in"><br />

	</form>
</body>
</html>