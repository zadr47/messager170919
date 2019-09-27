<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/include.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/class/user.php');

$data = $_REQUEST;

$user = new user($_SESSION['user_id']);

if(isset($data['do_make_with_friend'])){
	$user->do_make_with_friend($data['id']);
	header('location:/authorized/contacts/requests/incoming.php');
}

$arr_fans = $user->get_arr_fans();

foreach ($arr_fans as $k => $f) {
	$fans[] = new user($f->another_id);
}

require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/contacts/requests/incoming_html.php');

