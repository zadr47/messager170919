<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/include.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/class/login.php');

$data = $_REQUEST;

if(isset($data['do_log_in'])){
	$user = new login($data['login'],$data['password']);
	if($user->entry()){
		$_SESSION['user_id'] = $user->get_id();
		header("Location:/");
	}else{
		$message =	"<b>Ошибка авторизации!</b>
					 <p>Возможно вы ввели неправельный логин или пароль!</p>";
		require_once($_SERVER['DOCUMENT_ROOT'].'/authorized_not/log_in/log_in_html.php');
	}
}else{
	//кнопка не была нажата
	require_once($_SERVER['DOCUMENT_ROOT'].'/authorized_not/log_in/log_in_html.php');	
}
