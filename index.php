<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/include.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/class/user.php');
echo "<a href = '/DROP_TABLE.php'>DROP_TABLE</a><br />";
if(isset($_SESSION['user_id'])){
	$user = new user($_SESSION['user_id']);
}
//проверить существует ли авторизированный пользователь
if(isset($user)){
	//существует отправить на авторизованную страницу
	if($user->first_connection()){
		require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/secret_question/secret_question.php');
	}else{
		require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/authorized.php');
	}
}else{
	//не существует! отправить на не авторизованную страницу
	require_once($_SERVER['DOCUMENT_ROOT'].'/authorized_not/not_authorized.php');
}
