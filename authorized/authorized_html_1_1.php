<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>messager</title>
</head>
<body>

<div id="info">

	<b><?php echo $data_user['name'].' '.$data_user['last_name']; ?></b>
	<br />
	<p><?php echo date('d-m-o',$data_user['date_of_birth']); ?></p>
	<br />
	<img src="<?php echo $data_user['path_to_avatar'];?>" height="150px" width="150px">
	<br />

	<a href="/authorized/editing_avatar.php">сменить аву</a>
	<br />		
	<a href="/authorized/editing_info.php">редактировать</a>


</div>



<div id="content">
	<a href='/authorized/logout.php'>logout</a>
</div>

</body>
</html>