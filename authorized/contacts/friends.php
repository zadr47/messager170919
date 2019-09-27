<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/include.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/class/user.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/class/search.php');

create_table_friends();

is_access();

$data = $_REQUEST;

$user = new user($_SESSION['user_id']);

if(isset($data['do_search'])){
	if(!empty(trim($data['search']))){

		$search = new search('data_user',['name','last_name'],$data['search']);
		$result_search = $search->do_search();

		$arr_friends = $user->get_arr_friends();

		foreach ($arr_friends as $k => $f) {
			$arr_id_friends[] = $f->another_id;
		}

		foreach ($result_search as $k => $u) {
			foreach ($arr_id_friends as $id){
				if($u->id==$id){
					$search_friends[] = new user($u->id);
				}
			}
		}
		$friends = NULL;
		$friends = $search_friends;
	}
	if(empty($friends)){
		$message = "По вашему запросу не было надейно пользователей!";
	}
require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/contacts/friends_html.php');
exit();
}

if(isset($data['do_make_with_friend'])){
	$user->do_make_with_friend($data['id']);
	header('location:/authorized/contacts/friends.php');
}

$arr_friends_id = $user->get_arr_friends();
foreach ($arr_friends_id as $k => $v) {
	echo $f->friend_id;
	$friends[] = new user($v->another_id);
}






require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/contacts/friends_html.php');
