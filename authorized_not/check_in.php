<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/function.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/session.php');

//ТУТ ПРОИСХОДИТ РЕГИСТРАЦИЯ ПОЛЬЗОВАТЕЛЯ,ПРОВЕРКА НА ВАЛИДАЦИЮ

$data = $_REQUEST;

if(isset($data['do_check_in'])){
	//кнопка была нажата


	//проверка данных на валидацию
	$error = [];
	if(empty($data['login'])){
		$error[] = 'Введите логин!';
	}
	$data['login'] = trim($data['login']);
	if(!( 3 < strlen($data['login']) && strlen($data['login']) < 17)){
		$error[] = 'Ваш логин дожен содержать от 4 до 16 символов';
	}
	if(is_login($data['login'])){
		//проверка на универсальность логина
		$error[] = 'Данный логин уже существует!';
	}
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
		//ошибок нету можно заносить в БД
		$sql = "SELECT id FROM registration_data";
		$conn = conn();
		$result_query = $conn->query($sql);
		$arrID = $result_query->fetchAll(PDO::FETCH_ASSOC);
		$max_id = 0;
		foreach($arrID as $k => $v){
			foreach ($v as $id) {
				if($max_id < $id){
					$max_id = $id;
				}
			}
		}
		$id = $max_id;
		$id++;


		$login = $data['login'];
		$password = md5($data['password_1']);
		$date_reg = time();

		$sql = "INSERT INTO registration_data (id,login,password,date_reg,secret_question,answer) VALUES (?,?,?,?,?,?)";
		$snapshot = $conn->prepare($sql);
		$snapshot->execute([$id,$login,$password,$date_reg,NULL, NULL]);
		$conn = NULL;
		$_SESSION['connection'] = [
			'id'=>$id,
			'login'=>$login,
			'password'=>$password,
			'data_reg'=>$data_reg,
			'secret_question'=>NULL,
			'answer'=>NULL
		];
		header("Location:/");
	}else{
		//ошибки есть нужно вывести их на экран
		$message = $error[0];
		require_once($_SERVER['DOCUMENT_ROOT'].'/authorized_not/check_in_html.php');
	}
}else{
	//кнопка не была нажата
	require_once($_SERVER['DOCUMENT_ROOT'].'/authorized_not/check_in_html.php');	
}
