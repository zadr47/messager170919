<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/function.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/session.php');

$user = $_SESSION['connection'];
$data = $_REQUEST;

if($data['do_make_with_friend'] == 'Добавить в друзья'){
	$friend = 'yes';
}else{
	$friend = 'no';
}

$sql = "SELECT * FROM friends WHERE id = ".$user['id']." AND another_id = ".$data['id']." OR id = ".$data['id']." AND another_id = ".$user['id'].";";
$conn = conn();
$result_query = $conn->query($sql);
$data_DB = $result_query->fetch(PDO::FETCH_ASSOC);

if($data_DB['id']==$user['id']){
	$sql = "UPDATE friends SET friend = '".$friend."' WHERE id = ".$user['id']." AND another_id = ".$data['id'].";";
}else{
	$sql = "UPDATE friends SET another_friend = '".$friend."' WHERE id = ".$data['id']." AND another_id = ".$user['id'].";";	
}

if($conn->query($sql)){
	header('Location:/authorized/friends.php');
}
