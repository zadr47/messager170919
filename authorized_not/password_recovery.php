<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/function.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/session.php');

$data = $_REQUEST;

if(isset($data['do_login']) || isset($data['do_answer']) || isset($data['do_password'])){
	if(isset($data['do_login'])){
		$case = 1;
		$value = 'login';
	}else if(isset($data['do_answer'])){
		$case = 2;
		$value = 'answer';
	}else{
		$case = 3;
		$value = 'password';
	}
	$sql = "SELECT id,secret_question,answer,login FROM registration_data WHERE login = ?";
	$conn = conn();
	$snapshot = $conn->prepare($sql);
	$snapshot->execute([$data['login']]);
	$data_DB = $snapshot->fetch(PDO::FETCH_ASSOC);
	$conn = NULL;
	$id = $data_DB['id'];
	$question = $data_DB['secret_question'];
	$answer = $data_DB['answer'];
	$login = $data_DB['login'];

	$error = [];

	switch ($case) {
		case 1:
				if(empty($data['login'])){
					$error[] = 'Введите ваш логин!';
				}
				if(!is_login($data['login'])){
					$error[] = 'Указанного логина не существует!';
				}
				if(empty($error)){
					$value = 'answer';
					require_once($_SERVER['DOCUMENT_ROOT'].'/authorized_not/password_recovery_html.php');
				}else{
					$message = $error[0];
					require_once($_SERVER['DOCUMENT_ROOT'].'/authorized_not/password_recovery_html.php');
				}
			break;

		case 2:
				if(empty($data['answer'])){
					$error[] = 'Введите ваш ответ!';
				}
				if($data['answer']!=$answer){
					$error[] = 'Не верный ответ!';
				}
				if(empty($error)){

					$value = 'password';
					require_once($_SERVER['DOCUMENT_ROOT'].'/authorized_not/password_recovery_html.php');
				}else{
					$message = $error[0];
					require_once($_SERVER['DOCUMENT_ROOT'].'/authorized_not/password_recovery_html.php');
				}
			break;
		case 3:
				if(empty($data['password_1'])){
					$error[] = 'Придумайте пароль!';
				}
				if(!( 2 < strlen($data['password_1']) && strlen($data['password_1']) < 17)){
					$error[] = 'Ваш пароль дожен содержать от 3 до 16 символов';
				}
				if(empty($data['password_2'])){
					$error[] = 'Подтвердите пароль';
				}
				if(trim($data['password_1']) != trim($data['password_2'])){
					$error[] = 'Ваши пароли не совпадают!';
				}
				if(empty($error)){
					$password = md5($data['password_1']);
					$sql = "UPDATE registration_data SET password = '$password' WHERE id = $id;";
					$conn = conn();
					$conn->query($sql);
					$conn = NULL;
					header('location:/');
				}else{
					$message = $error[0];
					require_once($_SERVER['DOCUMENT_ROOT'].'/authorized_not/password_recovery_html.php');
				}
			break;
	}
}else{
	$value = 'login';
	require_once($_SERVER['DOCUMENT_ROOT'].'/authorized_not/password_recovery_html.php');
}