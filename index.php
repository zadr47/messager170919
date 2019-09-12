<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/function.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/session.php');

create_table_registration_data();


//проверить существует ли авторизированный пользователь

if(isset($_SESSION['connection'])){
	//существует отправить на авторизованную страницу
	if(empty($_SESSION['connection']['answer'])){
		require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/secret_question.php');
	}else{
		require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/authorized.php');
	}
}else{
	//не существует! отправить на не авторизованную страницу
	require_once($_SERVER['DOCUMENT_ROOT'].'/authorized_not/not_authorized.php');
}



