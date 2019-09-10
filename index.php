<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/function.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/session.php');

create_table_registration_data();

//проверить существует ли авторизированный пользователь

if(isset($_SESSION['connection'])){
	//существует отправить на авторизованную страницу
	if(empty($_SESSION['connection']['answer'])){
		require_once($_SERVER['DOCUMENT_ROOT'].'/secret_question.php');
	}else{
		
		echo "вы авторизованы <br />";
		echo "<a href='logout.php'>logout</a>";
		
	}
}else{
	//не существует! отправить на не авторизованную страницу
	require_once($_SERVER['DOCUMENT_ROOT'].'/not_authorized.html');
}



