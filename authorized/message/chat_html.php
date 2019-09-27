<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>friends</title>
	<style>
		#chat{
			position:relative; /* добавили */
			background:#DAE4E6;
			width:400px;
			height:400px;

		}
		ul{
			position: absolute;
			bottom:0;
			list-style-type:none;
			margin-left: 2px;
		    padding-left: 2px;

		}
		input[type=submit]  {
		    width: 20em;  
		    height: 2em;
		}
		input[type=text]  {
		    width: 400px;  
		    height: 10em;
		}
		
	</style>
</head>
<body>
	<a href="/authorized/go_to_index.php">Моя страница</a>
	<hr />
	<a href="/authorized/message/message.php">Сообщения</a>
	<hr />


	<a href="/authorized/user.php?id=<? echo $u->get_id(); ?>">
		<img src="<?php echo $u->get_path_to_avatar(); ?>" height="25px" width="25px">
		<b><?php echo $u->get_name().' '.$u->get_last_name(); ?></b>
	</a>

	

	<div id="chat">
<?php if(empty($chat)){ ?>
	Тут будет отображаться ваша переписка!
<?php }else{ ?>
	<ul>


<?php foreach($chat as $k => $v):						?>
<?php $mes_u = new user($v->id); ?>
<?php ?>
	<li>
	
	<img src="<?php echo $mes_u->get_path_to_avatar();?>" height="14px" width="14px">	
	<b><?php echo $mes_u->get_name().' '.$mes_u->get_last_name();?></b>
	<?php echo date('G:i:s d-m-y',$v->time_add);?>
	<br />
	<?php echo $v->message;?>
	<hr />
	</li>
<?php endforeach;								    	?>
	</ul>		
	</div>
	<form action="/authorized/message/chat.php" method="POST">
		<input type="text" name="message">
		<br />
		<input type="submit" name="do_message">
		<input type="hidden" name="id" value = "<?php echo $id_another_user; ?>">
	</form>
<?php } ?>
</body>
</html>