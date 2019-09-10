<?php

function damp($value){
	echo "<pre>";
	print_r($value);
	echo "</pre>";
}

function create_table_registration_data(){

	$conn = conn();

	try{
		$sql = "SELECT * FROM registration_data;";
		$conn->query($sql);

	}catch(PDOException $e){
		$sql = "CREATE TABLE registration_data ( id INT(11), login VARCHAR(255), password VARCHAR(255), date_reg INT(11) NOT NULL , secret_question VARCHAR(255) , answer VARCHAR(255) );";
		$conn->query($sql);
	}

	$conn = NULL;
}

function is_login($login){
	//логин существует?
	$conn = conn();
	$sql = "SELECT login FROM registration_data WHERE login = ?";
	$snapshot = $conn->prepare($sql);
	$snapshot->execute([$login]);
	$data_DB = $snapshot->fetchAll(PDO::FETCH_ASSOC);
	$count_login = count($data_DB);
	if($count_login > 0){
		return true;
	}else{
		return false;
	}
}

function is_true_password($login,$password){
	$conn = conn();
	$sql = "SELECT password FROM registration_data WHERE login = ?";
	$snapshot = $conn->prepare($sql);
	$snapshot->execute( [$login] );
	$data_DB = $snapshot->fetchAll(PDO::FETCH_ASSOC);
	$conn = NULL;
	$password_in_DB = $data_DB[0]['password'];
	if(md5($password)==$password_in_DB){
		return true;
	}else{
		return false;
	}
}