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

require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/authorized_html.php');
