<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/include.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/class/checkin.php');

$data = $_REQUEST;

if(isset($data['do_check_in'])){
	$checkin_user = new checkin($data['login'],$data['password_1'],$data['password_2']);
	if($checkin_user->can_reg()){
		$_SESSION['user_id'] = $checkin_user->reg();
		header("Location:/");
	}else{
		$message = "<b>Ошибка регистрации!</b><br />
					<p>Все поля должны быть заполнены!</p>
					<p>Логин должен содержать от 4 до 16 символов и быть уникальным!</p>
					<p>Пароль должен содержать от 3 до 16 символов!</p>
					<p>Пароли должны совпадать!</p>";
		require_once($_SERVER['DOCUMENT_ROOT'].'/authorized_not/check_in/check_in_html.php');
	}
}
require_once($_SERVER['DOCUMENT_ROOT'].'/authorized_not/check_in/check_in_html.php');	

