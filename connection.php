<?php

function conn(){

/*		
	//heroku
	$driver = 'pgsql';				
	$host = 'ec2-54-246-121-32.eu-west-1.compute.amazonaws.com';				
	$db_name = 'dfgngu63o3bvv0';
	$user = "siunpcbvdiimna";
	$charset = 'utf8';
	$pass = '5aceb95a0d56b72ac10c3ed0e3fb0465374f7a59d71c2727e47e67ac9853c7a1';
	$port = '5432';
	$dbpath ='';
	$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
*/	

	//опен сервер
	$driver = 'mysql';				
	$host = 'messager090919';				
	$db_name = 'messager090919';
	$user = "root";
	$charset = 'utf8';
	$pass = '';
	$port = '';
	$dbpath ='';
	$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

	switch ($driver) {
		case 'pgsql':
				$dbconn = "pgsql:host=$host;port=$port;dbname=$db_name";
			break;
		
		case 'mysql':
				$dbconn = "mysql:host=$host;dbname=$db_name";
			break;

		case 'sqlite':
				$dbconn = "sqlite:$dbpath";
			break;
	}

	try {  
		$conn = new PDO($dbconn,$user,$pass,$options);
		//echo "соединение прошло усешно!\nПрекрасно! Поздравляю!";
	}  
	catch(PDOException $e) {  
	    echo $e->getMessage();  
	}
	return $conn;
}
?>