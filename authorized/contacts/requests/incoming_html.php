<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>requests incoming</title>
</head>
<body>
	<a href="/authorized/go_to_index.php">Моя страница</a>
	<hr />
	<a href="/authorized/contacts/friends.php">Друзья</a>
	<a href="/authorized/contacts/online.php">Онлайн</a>
	<a href="/authorized/contacts/requests/incoming.php">Запросы</a>
	<hr />
	<a href="/authorized/contacts/requests/incoming.php">Входящие</a>
	<a href="/authorized/contacts/requests/outgoing.php">Исходящие</a>
	<hr />
	



<?php if(!empty($fans)){													 	?>
<?php foreach($fans as $k => $u):												?>


	<a href="/authorized/user.php?id=<?php echo $u->get_id(); ?>">
		<img src="<?php echo $u->get_path_to_avatar(); ?>" height="50px" width="50px">
		<b><?php echo $u->get_name().' '.$u->get_last_name(); ?></b>
	</a>

	<form action="/authorized/contacts/requests/incoming.php">
		<input type="submit" name="do_make_with_friend" value="Принять заявку в друзья">
		<input type="hidden" name="id" value="<?php echo $u->get_id(); ?>">
	</form>

	<hr />
<?php endforeach; 															 	?>
<?php }else{ 																 	?>
	
	<p>Тут отображаются ваши подписчики!</p>

<?php }																		 	?>

</body>
</html>