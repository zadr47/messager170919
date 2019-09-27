<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>messager</title>
</head>
<body>

<div id="info">
	
	<a href="/authorized/go_to_index.php">Моя страница</a>
	<br />
	<b><?php echo $another_user->get_name().' '.$another_user->get_last_name(); ?></b>
	<br />
	<p><?php echo date('d-m-o',$another_user->get_date_of_birth()); ?></p>
	<br />
	<img src="<?php echo $another_user->get_path_to_avatar();?>" height="150px" width="150px">
	<br />
	
	<form action ="/authorized/user.php" method="POST">
		<input type="submit" name="do_make_with_friend" value="<?php echo $relationship ?>">
		<input type="hidden" name="id" value="<?php echo $id_another_user ?>">
	</form>
	<br />		
	<a href="/authorized/my_message.php">Написать сообщение</a>


</div>



<div id="content">
	<a href='/authorized/logout.php'>logout</a>
</div>

</body>
</html>