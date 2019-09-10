<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/function.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/session.php');

//ТУТ ПРОИСХОДИТ АВТОРИЗАЦИЯ ПОЛЬЗОВАТЕЛЯ,ПРОВЕРКА НА ВАЛИДАЦИЮ

$data = $_REQUEST;

if(isset($data['do_log_in'])){
	//кнопка была нажата

	//проверка данных на валидацию
	$error = [];
	if(empty($data['login'])){
		$error[] = 'Введите логин!';
	}
	if(!is_login($data['login'])){
		//проверка на универсальность логина
		$error[] = 'Данный логин не существует!';
	}
	if(empty($data['password'])){
		$error[] = 'Введите пароль!';
	}
	if(!is_true_password($data['login'],$data['password'])){
		$error[] = 'Не верно введен пароль!';
	}
	if(empty($error)){
		//ошибок нету можно заносить в БД

		$sql = "SELECT * FROM registration_data WHERE login = ?";		
		$conn = conn();
		$snapshot = $conn->prepare($sql);
		$snapshot->execute([$data['login']]);
		$data_DB = $snapshot->fetch(PDO::FETCH_ASSOC);
		$conn = NULL;
		$_SESSION['connection'] = [
			'id'=>$data_DB['id'],
			'login'=>$data_DB['login'],
			'password'=>$data_DB['password'],
			'date_reg'=>$data_DB['date_reg'],
			'secret_question'=>$data_DB['secret_question'],
			'answer'=>$data_DB['answer']
		];
		header("Location:/");
	}else{
		//ошибки есть нужно вывести их на экран
		$message = $error[0];
		require_once($_SERVER['DOCUMENT_ROOT'].'/log_in_html.php');
	}
}else{
	//кнопка не была нажата
	require_once($_SERVER['DOCUMENT_ROOT'].'/log_in_html.php');	
}
