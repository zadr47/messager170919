<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/include.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/class/user.php');

$user = new user($_SESSION['user_id']);

$data = $_REQUEST;

if(isset($data['do_editing_info'])){
	//damp($data);
	$user->update_info_of_user($data['name'],$data['last_name'],$data['date_of_birth']);
	header('Location:/');
	
}else{
	require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/editing/info_html.php');
}