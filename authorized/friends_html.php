<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>messager</title>
</head>
<body>

<div id="info">

	<a href="/authorized/go_to_index.php">моя страница</a><br />
	<form action="/authorized/friends.php"method="POST">
		<button name="go_to" value="my_friend">Мои друзяки</button>
		<button name="go_to" value="my_subscribers">Подписчики</button>
		<button name="go_to" value="my_subscriptions">Подписки</button>
	</form>

	<form action="/authorized/search.php" method="POST">
		Поиск по:
		<button name="type_search" value="name">name</button>
		<button name="type_search" value="login">login</button>
		<button name="type_search" value="id">id</button>
		<br />
		<input type="text" name="search" placeholder="выведите поисковый запрос" value="<?php echo @$_REQUEST['search'] ?>">
		<input type="submit" name="do_search" value="найти">
		<input type="hidden" name="go_to" value="search">
	</form>
	<?php if(!empty($message))
		echo $message;
		echo "<br/>";
	?>



<?php 	if(empty($_REQUEST['go_to'])){ 					?>
<?php 		$_REQUEST['go_to'] = 'my_friend';			?>
<?php	}												?>
<?php	switch($_REQUEST['go_to']){						?>
<?php	case 'my_friend': 								?>


		Ваши друзья!
		<br />


<?php 	if(!empty($my_friends)){ 						?>
<?php		foreach($my_friends as $k => $v){			?>


		<a href="/authorized/user.php?user_id=<?php echo $v['id']; ?>">
			<img src="<?php echo $v['path_to_avatar']; ?>" height="50px" width="50px">
			<b><?php echo $v['name'].' '.$v['last_name']; ?></b>
		</a>
		<form action="/authorized/make_with_friend.php" method="POST">
			<input type="submit" name="do_make_with_friend" value="Удалить из друзей">
			<input type="hidden" name="id" value="<?php echo $v['id'] ?>">
		</form>


<?php		}		  						?>
<?php	}else{								?>


		<p>Тут отображаются выши друзья!</p>


<?php 	} 													?>
<?php	break;												?>
<?php	case 'my_subscribers'://подписчики  				?>


		Ваши подписчики!
		<br />


<?php 	if(!empty($my_subscribers)){ 						?>
<?php		foreach($my_subscribers as $k => $v){			?>


		<a href="/authorized/user.php?user_id=<?php echo $v['id']; ?>">
			<img src="<?php echo $v['path_to_avatar']; ?>" height="50px" width="50px">
			<b><?php echo $v['name'].' '.$v['last_name']; ?></b>
		</a>
		<form action="/authorized/make_with_friend.php" method="POST">
			<input type="submit" name="do_make_with_friend" value="Добавить в друзья">
			<input type="hidden" name="id" value="<?php echo $v['id'] ?>">
		</form>


<?php		}												?>
<?php	}else{												?>


		<p>Тут отображаются ваши подписчики!</p>


<?php	}													?>
<?php	break;
		case 'my_subscriptions'://подписки					?>


		Ваши подписки!
		<br />


<?php	if(!empty($my_subscriptions)){						?>
<?php		foreach($my_subscriptions as $k => $v){			?>
		

		<a href="/authorized/user.php?user_id=<?php echo $v['id']; ?>">
			<img src="<?php echo $v['path_to_avatar']; ?>" height="50px" width="50px">
			<b><?php echo $v['name'].' '.$v['last_name']; ?></b>
		</a>
		<form action="/authorized/make_with_friend.php" method="POST">
			<input type="submit" name="do_make_with_friend" value="Отменить подписку">
			<input type="hidden" name="id" value="<?php echo $v['id'] ?>">
		</form>


<?php		}												?>
<?php	}else{												?>


		<p>Тут отображаются ваши подписки</p>


<?php	}													?>
<?php	break;												?>
<?php	case 'search'://поиск						?>


		Рузультат поиска!
		<br />


<?php	if(!empty($my_search)){						?>
<?php		foreach($my_search as $k => $v){		?>
<?php		if($v['relation_to_me'] == 'delete_frend'){$v['relation_to_me'] = 'Удалить из друзей';}			?>
<?php		if($v['relation_to_me'] == 'add_to_frends'){$v['relation_to_me'] = 'Добавить в друзья';}		?>
<?php		if($v['relation_to_me'] == 'cancel_quiry_to_frend'){$v['relation_to_me'] = 'Отменить подписку';}?>

		

		<a href="/authorized/user.php?user_id=<?php echo $v['id']; ?>">
			<img src="<?php echo $v['path_to_avatar']; ?>" height="50px" width="50px">
			<b><?php echo $v['name'].' '.$v['last_name']; ?></b>
		</a>
		<form action="/authorized/make_with_friend.php" method="POST">
			<input type="submit" name="do_make_with_friend" value="<?php echo $v['relation_to_me'] ?>">
			<input type="hidden" name="id" value="<?php echo $v['id'] ?>">
		</form>


<?php		}								?>
<?php	}else{								?>


		<p>Ничего не найдено по вашему запросу</p>


<?php	}									?>
<?php	break;								?>
<?php	}									?>
	

</div>



<div id="content">
	<a href='/authorized/logout.php'>logout</a>
</div>

</body>
</html>