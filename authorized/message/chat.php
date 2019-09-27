<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/include.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/class/user.php');

$user = new user($_SESSION['user_id']);

$data = $_REQUEST;

$id_another_user = htmlspecialchars($data['id']);

if(isset($data['do_message'])){
	if(!empty(trim($data['message']))){
		$message = htmlspecialchars(trim($data['message']));
		$user->add_message($id_another_user,$message);
	}
}

$u = new user($id_another_user);

$chat = $user->get_chat($id_another_user);

require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/message/chat_html.php');