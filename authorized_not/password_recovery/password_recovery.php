<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/include.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/class/recovery.php');

$data = $_REQUEST;

$recovery = new recovery(htmlspecialchars(trim($data['login'])));
if($data['do_recovery'] == 'login'){
	if($recovery->check_login()){
		require_once($_SERVER['DOCUMENT_ROOT'].'/authorized_not/password_recovery/answer.php');
		exit();		
	}
}
if($data['do_recovery'] == 'answer'){
	if($recovery->check_answer(htmlspecialchars($data['answer']))){
		require_once($_SERVER['DOCUMENT_ROOT'].'/authorized_not/password_recovery/password.php');
		exit();		
	}else{
		require_once($_SERVER['DOCUMENT_ROOT'].'/authorized_not/password_recovery/answer.php');
		exit();
	}
}
if($data['do_recovery'] == 'password'){
	if($recovery->check_password(htmlspecialchars($data['password_1']),htmlspecialchars($data['password_2']))){
		$recovery->update_password(htmlspecialchars($data['password_1']));
		$_SESSION['user_id'] = $recovery->get_id_by_login();
		header('Location:/');
	}else{
		require_once($_SERVER['DOCUMENT_ROOT'].'/authorized_not/password_recovery/password.php');	
		exit();	
	}
}
require_once($_SERVER['DOCUMENT_ROOT'].'/authorized_not/password_recovery/login.php');


