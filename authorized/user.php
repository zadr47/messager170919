<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/include.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/class/user.php');

is_access();

$user = new user($_SESSION['user_id']);

$data = $_REQUEST;

$id_another_user = htmlspecialchars($data['id']);

if($user->get_id()==$id_another_user){
	header('Location:/');
}

if(isset($data['do_make_with_friend'])){
	$user->do_make_with_friend($data['id']);
	header('location:/authorized/user.php?id='.$id_another_user);
}


$another_user = new user($id_another_user);

$relationship = $user->get_relationship_to($another_user->get_id());

if($relationship == 'fan'){
	$relationship = 'Отменить заявку в друзья';
}
if($relationship == 'not_fan'){
	$relationship = 'Принять заявку в друзья';
}
if($relationship == 'friends'){
	$relationship = 'Удалить из друзей';
}
if($relationship == 'not_friends'){
	$relationship = 'Добавить в друзья';
}
if(empty($relationship)){
	$relationship = 'Добавить в друзья';
}

require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/user_html.php');


