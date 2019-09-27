<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>messager</title>
</head>
<body>

<div id="info">

	<b><?php echo $user->get_name().' '.$user->get_last_name(); ?></b>
	<br />

	<?php if($user->get_date_of_birth() != 0){					?>
	<p><?php echo date('d-m-o',$user->get_date_of_birth()); ?></p>
	<br />
	<?php }	else{												?>
	<p>День рожденья не указан</p>
	<br />
	<?php }														?>
	<img src="<?php echo $user->get_path_to_avatar();?>" height="150px" width="150px">
	<br />

	<a href="/authorized/editing/avatar.php">сменить аву</a>
	<br />		
	<a href="/authorized/editing/info.php">редактировать</a>
	<br />		
	<a href="/authorized/contacts/friends.php">друзья</a>
	<br />		
	<a href="/authorized/message/message.php">сообщения</a>


</div>



<div id="content">
	<a href='/authorized/logout.php'>logout</a>
</div>

</body>
</html>