<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/include.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/class/user.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/class/search.php');

$data = $_REQUEST;

$user = new user($_SESSION['user_id']);

if(isset($data['do_make_with_friend'])){
	$user->do_make_with_friend($data['id']);
	header('location:/authorized/contacts/search_users.php');
}

if(isset($data['do_search'])){
	if(!empty(trim($data['search']))){
		$search = new search('data_user',['name','last_name'],$data['search']);
		$result_search = $search->do_search();
		foreach ($result_search as $k => $u) {
			$users[] = new user($u->id);
		}
	}
	if(empty($users)){
		$message = 'По вашему поиску ничего не найдено!';
	}
}
require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/contacts/search_users_html.php');