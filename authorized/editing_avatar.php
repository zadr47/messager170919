<?php 

require_once($_SERVER['DOCUMENT_ROOT'].'/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/function.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/session.php');

$user = $_SESSION['connection'];

$data = $_REQUEST;

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
	$id_avatar = 'NULL';
	$sql = "INSERT INTO data_user (id, name, last_name, date_of_birth, path_to_avatar)
				VALUES ($id,'$name','$last_name',$date_of_birth,$id_avatar);";
	$conn->query($sql);

	$sql = "SELECT * FROM data_user WHERE id = ".$user['id'].";";
	$result_query = $conn->query($sql);
	$data_user = $result_query->fetch(PDO::FETCH_ASSOC);
}

$conn = NULL;



//былали назата кнопка сохранить файл
if(isset($data['do_editing_avatar'])){
	//файл пришёл


	if($_FILES['avatar']['tmp_name'] != ''){

		//нужно поместить файл в папку /img/user_id/
		//и записать адрес храниния в data_user.path_to_avatar
		$avatar = $_FILES['avatar'];

		//проверяю есть ли у этого пользователя уже папка
		$path_to_img = $_SERVER['DOCUMENT_ROOT'].'/img';
		if(!file_exists($path_to_img)){
			mkdir($path_to_img) or die ('не удалось создать папку "img"!');
		}
		$path_to_user_id = $_SERVER['DOCUMENT_ROOT'].'/img/user_'.$user['id'];
		if(!file_exists($path_to_user_id)){
			mkdir($path_to_user_id) or die ('не удалось сощдать папку "user_id"');
		}

		//нужно проверить есть ли у пользователя аватарки
		$path_to_standard_avatar = '/img/standard/standard_avatar.jpg';
		if($path_to_standard_avatar == $data_user['path_to_avatar']){
			$id_avatar = 1;
		}else{	
			preg_match('/_([0-9]+)\./sx',$data_user['path_to_avatar'],$arrPath_to_avatar);
			$id_avatar = $arrPath_to_avatar[1];
			$id_avatar++;
		}
		//дальше нужно занести аватар в папку с нужным id
		//и занести путь к этому аватару

		$filename = $_FILES['avatar']['tmp_name'];
		$path_to_user_avatar = $_SERVER['DOCUMENT_ROOT'].'/img/user_'.$user['id'].'/avatar_'.$id_avatar.'.jpg';
		move_uploaded_file($filename, $path_to_user_avatar);

		$path_to_user_avatar = '/img/user_'.$user['id'].'/avatar_'.$id_avatar.'.jpg';
		$sql = "UPDATE data_user SET path_to_avatar = '".$path_to_user_avatar."' WHERE id = ".$user['id'].";";
		$conn = conn();
		$conn->query($sql);
		$conn = NULL;		

	}
	
	header('Location:/');

}else{
	require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/editing_avatar_html.php');		
}




