<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>friends</title>
</head>
<body>
	<a href="/authorized/go_to_index.php">Моя страница</a>
	<hr />
	<a href="/authorized/contacts/friends.php">Друзья</a>
	<a href="/authorized/contacts/online.php">Онлайн</a>
	<a href="/authorized/contacts/requests/incoming.php">Запросы</a>
	<hr />
	<form action="/authorized/contacts/friends.php" method="POST">
		<input type="text" name="search" placeholder="Введите запрос">
		<input type="submit" name="do_search" value="Найти">
	</form>
	<a href="/authorized/contacts/search_users.php">Найти пользователя</a>
	<hr />



<?php if(!empty($friends)){													 	?>
<?php foreach($friends as $k => $f):											?>
	
	<a href="/authorized/user.php?id=<? echo $f->get_id(); ?>">
		<img src="<?php echo $f->get_path_to_avatar(); ?>" height="50px" width="50px">
		<b><?php echo $f->get_name().' '.$f->get_last_name(); ?></b>
	</a>

	<form action="/authorized/contacts/friends.php">
		<input type="submit" name="do_make_with_friend" value="Удалить из друзей">
		<input type="hidden" name="id" value="<?php echo $f->get_id(); ?>">
	</form>

	<hr />
<?php endforeach; 															 	?>
<?php }else{ 																 	?>
<?php if(isset($message)){													 	?>
<?php 	echo $message;														 	?>
<?php }else{																 	?>
		<p>Тут будут отображаться ваши друзья!<p>
<?php }																		 	?>
<?php }																		 	?>

</body>
</html>