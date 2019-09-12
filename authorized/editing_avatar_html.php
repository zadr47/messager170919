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

	<form action="/authorized/editing_avatar.php" method="POST" enctype="multipart/form-data">
		<input type="file" name="avatar"><br />
		<input type="submit" name="do_editing_avatar" value="сохранить">
	</form>
	
</div>




<div id="content">
	<a href='/authorized/logout.php'>logout</a>
</div>

</body>
</html>