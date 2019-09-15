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
	<b><?php echo $data_another_user['name'].' '.$data_another_user['last_name']; ?></b>
	<br />
	<p><?php echo date('d-m-o',$data_another_user['date_of_birth']); ?></p>
	<br />
	<img src="<?php echo $data_another_user['path_to_avatar'];?>" height="150px" width="150px">
	<br />


<?php		$u = $data_another_user;																		?>
<?php		if($u['relation_to_me'] == 'delete_frend'){$u['relation_to_me'] = 'Удалить из друзей';}			?>
<?php		if($u['relation_to_me'] == 'add_to_frends'){$u['relation_to_me'] = 'Добавить в друзья';}		?>
<?php		if($u['relation_to_me'] == 'cancel_quiry_to_frend'){$u['relation_to_me'] = 'Отменить подписку';}?>

	
	<form action ="/authorized/make_with_friend.php" method="POST">
		<input type="submit" name="do_make_with_friend" value="<?php echo $u['relation_to_me'] ?>">
		<input type="hidden" name="id" value="<?php echo $id_another_user ?>">
	</form>
	<br />		
	<a href="">Написать сообщение</a>


</div>



<div id="content">
	<a href='/authorized/logout.php'>logout</a>
</div>

</body>
</html>