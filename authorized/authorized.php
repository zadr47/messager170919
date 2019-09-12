<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/function.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/session.php');

create_table_data_user();

is_access();


$user = $_SESSION['connection'];


$conn = conn();

$sql = "SELECT * FROM data_user WHERE id = ".$user['id'].";";
$result_query = $conn->query($sql);
$data_user = $result_query->fetch(PDO::FETCH_ASSOC);


if(empty($data_user)){

	$sql = "SELECT * FROM registration_data WHERE id = ".$user['id'].";";
	$result_query = $conn->query($sql);
	$data_DB = $result_query->fetch(PDO::FETCH_ASSOC);
	$id = $data_DB['id'];
	$name = $data_DB['login'];
	$last_name = $data_DB['login'];
	$date_of_birth = 'NULL';
	$id_avatar = '/img/standard/standard_avatar.jpg';
	$sql = "INSERT INTO data_user (id, name, last_name, date_of_birth, path_to_avatar)
				VALUES ($id,'$name','$last_name',$date_of_birth,'$id_avatar');";
	$conn->query($sql);

	$sql = "SELECT * FROM data_user WHERE id = ".$user['id'].";";
	$result_query = $conn->query($sql);
	$data_user = $result_query->fetch(PDO::FETCH_ASSOC);
}


$conn = NULL;

$data = $_REQUEST;

require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/authorized_html_1_1.php');




//в данный момент вся информация о пользователе собрана что бы ее отобразить
//дальше нужно выяснить какое действие совершил пользователь что бы обработать 

//лучше сделать ссылки при нажатии на действие что бы не было путаницы
//и в каждом отдельном файле их обрабатывать


exit();

//кнопка была нажата
//выяснить какая
if(isset($data['do_editing'])){

	$case_html = 'editing_info_save';

}

if(isset($data['do_info_save'])){

	$case_php = $data['button'];

	if(empty(trim($data['name']))){
		$data['name'] = $data_user['name'];
	}
	if(empty(trim($data['last_name']))){
		$data['last_name'] = $data_user['last_name'];
	}

	if(empty($data['date_of_birth'])){

		$sql = "UPDATE data_user SET name = ?, last_name = ? WHERE id = ".$user['id'].";";
		$conn = conn();
		$snapshot = $conn->prepare($sql);
		$snapshot->execute([$data['name'],$data['last_name']]);
		$conn = NULL;

	}else{

		$arrDate = explode('-',$data['date_of_birth']);

		$day = $arrDate[2];
		$month = $arrDate[1];
		$year = $arrDate[0];

		$time_birth = mktime(0,0,0,$month,$day,$year);
		$sql = "UPDATE data_user SET name = ?, last_name = ?, date_of_birth = ? WHERE id = ".$user['id'].";";
		$conn = conn();
		$snapshot = $conn->prepare($sql);
		$snapshot->execute([$data['name'],$data['last_name'],$time_birth]);
		$conn = NULL;
	}
}


if(isset($data['do_editing_avatar'])){
	$case_html = 'editing_avatar_save';
	require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/authorized_html.php');	
}

if(isset($data['do_editing_avatar_save'])){
	if(empty($_FILES['avatar']['name'])){
		require_once($_SERVER['DOCUMENT_ROOT'].'/authorized_html.php');
	}else{

		
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/img')) {
		    mkdir($_SERVER['DOCUMENT_ROOT'].'/img') or die("не удалось создать папку");
		}
	    if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/img/user'.$user['id'])){
		    mkdir($_SERVER['DOCUMENT_ROOT'].'/img/user'.$user['id']) or die("не удалось создать папку");
		}

		$sql = "SELECT path_to_avatar FROM data_user WHERE id = ".$user['id'].";";
		$conn = conn();
		$result_query = $conn->query($sql);
		$data_DB = $result_query->fetch(PDO::FETCH_ASSOC);
		$conn = NULL;

		$path_to_avatar = $data_DB['path_to_avatar'];
		
		if($path_to_avatar === NULL){
			$path_to_avatar = 1;
		}else{
			echo $path_to_avatar;
			echo "<br />";
			$path_to_avatar = substr($path_to_avatar, 18,1);
			echo $path_to_avatar;
			$path_to_avatar++;
		}

		$avatar = $_FILES['avatar']['tmp_name'];
		
		$path_to_avatar = '/img/user'.$user['id'].'/avatar_'.$path_to_avatar.'.jpg';
		move_uploaded_file($avatar,$_SERVER['DOCUMENT_ROOT'].'/'.$path_to_avatar) or die ("не получилось");
		$sql = "UPDATE data_user SET path_to_avatar = ? WHERE id = ".$user['id'];
		$conn = conn();
		$snapshot = $conn->prepare($sql);
		$snapshot->execute([$path_to_avatar]);
		$conn = NULL;

		require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/authorized_html_1_1.php');

	}
}

//if(isset($data['do_save'])){



require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/authorized_html.php');
