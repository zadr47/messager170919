<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>search users</title>
</head>
<body>
	<a href="/authorized/go_to_index.php">Моя страница</a>
	<hr />
	<a href="/authorized/contacts/friends.php">Друзья</a>
	<a href="/authorized/contacts/subscriber.php">Онлайн</a>
	<a href="/authorized/contacts/requests/incoming.php">Запросы</a>
	<hr />
	<form action="/authorized/contacts/search_users.php" method="POST">
		<input type="text" name="search" placeholder="Введите запрос">
		<input type="submit" name="do_search" value="Найти">
	</form>
	<a href="/authorized/contacts/search_users.php">Найти пользователя</a>
	<hr />



<?php if(!empty($users)){													 	?>
<?php foreach($users as $k => $u):												?>

<?php		if($user->get_relationship_to($u->get_id()) == 'fan'){				?>
<?php			$relationship = 'Отменить подписку';							?>
<?php		}																	?>
<?php		if($user->get_relationship_to($u->get_id()) == 'not_fan'){			?>
<?php			$relationship = 'Принять заявку';								?>
<?php		}																	?>
<?php		if($user->get_relationship_to($u->get_id()) == 'friends'){			?>
<?php			$relationship = 'Удалить из друзей';							?>
<?php		}																	?>
<?php		if($user->get_relationship_to($u->get_id()) == 'not_friends'){		?>
<?php			$relationship = 'Добавить в друзья';							?>
<?php		}																	?>
<?php		if(empty($relationship)){											?>
<?php			$relationship = 'Добавить в друзья';							?>
<?php		}																	?>
<?php		echo $user->get_relationship_to($u->get_id());						?>



	<a href="/authorized/user.php?id=<?php echo $u->get_id(); ?>">
		<img src="<?php echo $u->get_path_to_avatar(); ?>" height="50px" width="50px">
		<b><?php echo $u->get_name().' '.$u->get_last_name(); ?></b>
	</a>

	<form action="/authorized/contacts/search_users.php">
		<input type="submit" name="do_make_with_friend" value="<?php echo $relationship; ?>">
		<input type="hidden" name="id" value="<?php echo $u->get_id(); ?>">
	</form>

	<hr />
<?php endforeach; 															 	?>
<?php }else{ 																 	?>
<?php if(!empty($message)){													 	?>
<?php echo $message; 														 	?>
<?php }else{		 														 	?>
	
	<p>Тут будет отображаться результат поиска!</p>

<?php }																		 	?>
<?php }																			?>

</body>
</html>