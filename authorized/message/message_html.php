<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>friends</title>
</head>
<body>
	<a href="/authorized/go_to_index.php">Моя страница</a>
	<hr />
	<a href="/authorized/message/message.php">Сообщения</a>
	<hr />
	<form action="/authorized/message/message.php" method="POST">
		<input type="text" name="search" placeholder="Введите запрос">
		<input type="submit" name="do_search" value="Найти">
	</form>
	<hr />



<?php if(!empty($arr_chats)){													 	?>
<?php foreach($arr_chats as $k => $c):											?>
<?php $u = $arr_users[$k];											?>
	
	<a href="/authorized/message/chat.php?id=<?php echo $u->get_id(); ?>">
		<img src="<?php echo $u->get_path_to_avatar(); ?>" height="25px" width="25px">
		<b><?php echo $u->get_name().' '.$u->get_last_name(); ?></b>
	</a>
	<hr />
<?php endforeach; 															 	?>
<?php }else{ 																 	?>
		<p>Тут будут отображаться ваши чаты!<p>
<?php }																		 	?>

</body>
</html>