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

if(isset($data['do_editing_info'])){

	$arr_data_need_to_update = [];

	if(!trim(empty($data['name']))){
		$arr_data_need_to_update['name'] = $data['name'];
	}
	if(!trim(empty($data['last_name']))){
		$arr_data_need_to_update['last_name'] = $data['last_name'];		
	}
	if(!empty($data['date_of_birth'])){

		$arr_date = explode('-',$data['date_of_birth']);
		$day = $arr_date[2];
		$month = $arr_date[1];
		$year = $arr_date[0];
		$arr_data_need_to_update['date_of_birth'] = mktime(0,0,0,$month,$day,$year);

	}

	if(!empty($arr_data_need_to_update)){
		//сформировать sql запрос

		$arr_keys = array_keys($arr_data_need_to_update);


		$sql = "UPDATE data_user SET";

		foreach ($arr_keys as $k => $v) {
			$sql.=" ".$v." = ? ,";
		}
		$a =  iconv_strlen($sql);
		preg_match('/(.+),/sx',$sql,$arr);
		$sql = $arr[1];
		

		$sql.= " WHERE id = ".$user['id'].";";
		$conn = conn();
		$snapshot = $conn->prepare($sql);

		$count_arr_keys = count($arr_keys);

		switch ($count_arr_keys) {
			case 1:
				$snapshot->execute([$arr_data_need_to_update[$arr_keys[0]]]);
				break;
			case 2:			
				$snapshot->execute([$arr_data_need_to_update[$arr_keys[0]],$arr_data_need_to_update[$arr_keys[1]]]);
				break;
			case 3:
				$snapshot->execute([$arr_data_need_to_update[$arr_keys[0]],$arr_data_need_to_update[$arr_keys[1]],$arr_data_need_to_update[$arr_keys[2]]]);
				break;	
		}	
		
		$conn = NULL;
	}
	header('Location:/');
	
}else{
	require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/editing_info_html.php');
}