<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/include.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/class/user.php');

create_table_data_user();

is_access();


$user = new user($_SESSION['user_id']);
//damp($user);

if($_SESSION['user_id']==1){
	echo "<a href='/DROP_TABLE.php'>DROP_TABLE</a>";
}


$data = $_REQUEST;

require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/authorized_html.php');
