<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/include.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/class/user.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/class/search.php');

$user = new user($_SESSION['user_id']);

$data = $_REQUEST;

$arr_chats = $user->get_chats();


if(isset($data['do_search'])){
	if(!empty(trim($data['search']))){
		$search = new search('data_user',['name','last_name'],$data['search']);
		$result_search = $search->do_search();
		if(!empty($result_search)){
			$arr_chats = $result_search;
		}
	}
}

damp($arr_chats);
exit();

if(!empty($arr_chats)){
	foreach ($arr_chats as $k => $v) {
		$arr_users[] = new user($v->another_id);
	}
}

require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/message/message_html.php');