<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>messager</title>
</head>
<body>

<div id="info">
		
		<form action="/authorized/editing_info.php" method="POST" >
		<b>
			<input type="text" name="name" placeholder="your_name" value="<?php echo @$data_user['name'] ?>">
			<?php echo ' '; ?>
			<input type="text" name="last_name" placeholder="your_last_name" value="<?php echo @$data_user['last_name'] ?>">
		</b>
		
		<br />
		<p>
			<input type="date" name="date_of_birth" placeholder="your_birth" value="<?php echo date('d-m-o',$data_user['date_of_birth']); ?>">
		</p>
		<br />
		<img src="<?php echo $data_user['path_to_avatar'];?>" height="150px" width="150px">
		<br />
			<input type="submit" name="do_editing_info" value="save">	
		</form>
	</div>




<div id="content">
	<a href='/authorized/logout.php'>logout</a>
</div>

</body>
</html>