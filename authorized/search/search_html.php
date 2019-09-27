<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>search</title>
</head>
<body>
	<a href="/authorized/go_to_index.php">Моя страница</a>
	<hr />
	Поиск
	<form action="/authorized/search/search.php">
		<input type="radio" name="table" value="data_user" <?php echo $data_user; ?> >Люди
		<input type="radio" name="table" value="music" <?php echo $music; ?> >Музыка
		<input type="radio" name="table" value="news" <?php echo $news; ?> >Новости
		<br />
		<input type="text" name="search" placeholder="Введите запрос">
		<input type="submit" name="do_search" value="Найти">
		<input type="hidden" name="return_search_to" value="/authorized/search/search_html.php">
	</form>
	<hr />
	
	<?php if(!empty($friends)){													 	?>
<?php foreach($friends as $k => $f):											?>
	
	<a href="/authorized/another/user.php?id=<? echo $f->get_id(); ?>">
		<img src="<?php echo $f->get_path_to_avatar(); ?>" height="50px" width="50px">
		<b><?php echo $f->get_name().' '.$f->get_last_name(); ?></b>
	</a>

	<form action="/authorized/friends/make_with_friend.php">
		<input type="submit" name="do_make_with_friend" value="Удалить из друзей">
		<input type="hidden" name="id" value="<?php echo $f->get_id(); ?>">
	</form>

	<hr />
<?php endforeach; 															 	?>
<?php }else{ 																 	?>
	По вашему вопросу ничего не найдено
<?php }																		 	?>
	

</body>
</html>