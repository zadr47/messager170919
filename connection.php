<?php

function conn(){

	####

	//heroku
	$driver = 'pgsql';				
	$host = 'ec2-54-83-33-14.compute-1.amazonaws.com';				
	$db_name = 'dd1qpeu338vg4e';
	$user = "abwckpidopjjfk";
	$charset = 'utf8';
	$pass = 'ed726fd42c85974440cb161eabf2007e253bc21197ace9642573231155a7b1fe';
	$port = '5432';
	$dbpath ='';
	$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

/*		
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
*/	

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