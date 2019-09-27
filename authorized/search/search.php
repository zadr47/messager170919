<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/include.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/class/user.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/class/search.php');

$data = $_REQUEST;

if(empty(trim($data['search']))){
	header('location:'.$data['return_search_to']);	
}

if($data['table'] == 'friends'){
	$search = new search('friends','id',$_SESSION['user_id']);
	$arr_friends_with_my_id = $search->do_search();
	foreach ($arr_friends_with_my_id as $key => $f) {
		$arr_id_my_friends[] = $f->another_id;
	}
	$search = new search('data_user',['name','last_name'],$data['search']);
	$data_search = $search->do_search();

	foreach ($data_search as $k => $f) {
		$friends[] = new user($f->id);
	}
	require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/friends/friends_html_1_1.php');
	exit();
}
if(empty($data['table'])){
	$table = 'data_user';
	$key = ['name','last_name'];
	$search = new search($table,$key,$data['search']);
	$arr_result_search = $search->do_search();
	foreach($arr_result_search as $k => $f){
		$friends[] = new user($f->id);
	}
	damp($friends);
	require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/search/search_html.php');
	exit();
}
//damp($data);
//damp($friends);
/*
$table = 'data_user';

if(isset($data['table'])){
	$table = $data['table'];
}

$key = ['name','last_name'];

$search = new search($table,$key,$data['search']);

damp($search);

$friends = $search->do_search();

damp($friends);
*/




































































/*
require_once($_SERVER['DOCUMENT_ROOT'].'/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/function.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/session.php');

is_access();

$data = $_REQUEST;

$user = $_SESSION['connection'];

$_REQUEST['go_to'] = $data['go_to'];


if(isset($data['do_search']) || $data['type_search']){
	//проверить заполнино ли поле запроса
	if(empty(trim($data['search']))){
		$message = 'заполните поле запроса';
		require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/friends_html.php');
	}else{
		if(empty($data['type_search'])){
			$data['type_search'] = 'name';
		}

		$str = htmlspecialchars(trim($data['search']));
		$arr_str = explode(' ',$str);
		
		$sql = "SELECT * FROM data_user WHERE ";

		switch ($data['type_search']){
			case 'name':
				foreach ($arr_str as $k => $v) {
					if(!empty(trim($v))){
						if(isset($arr_str[$k - 1])){
							$sql .= ' OR ';
						}
						$sql .= "name LIKE ? OR last_name LIKE ?";
						$arr_to_execute[] = '%'.$v.'%';
						$arr_to_execute[] = '%'.$v.'%';
					}
				}
				break;
			case 'login':
				$sql = "SELECT * FROM registration_data WHERE ";
				foreach ($arr_str as $k => $v) {
					if(!empty(trim($v))){

						if(isset($arr_str[$k - 1])){
							$sql .= ' OR ';
						}
						$sql .= "login LIKE ?";
						$arr_to_execute[] = '%'.$v.'%';
					}
				}
				break;
			case 'id':
				foreach ($arr_str as $k => $v) {
					if(!empty(trim($v))){

						if(isset($arr_str[$k - 1])){
							$sql .= ' OR ';
						}
						$sql .= "id = ?";
						$arr_to_execute[] = $v;
					}
				}
				break;
		}
		$conn = conn();
		$snapshot = $conn->prepare($sql);
		$snapshot->execute($arr_to_execute);
		$search = $snapshot->fetchAll(PDO::FETCH_ASSOC);


		foreach ($search as $k => $u) {
			if(!isset($u['name'])){
				$sql = "SELECT * FROM data_user WHERE id = ".$u['id'].";";
				$result_query = $conn->query($sql);
				$data_DB = $result_query->fetch(PDO::FETCH_ASSOC);
				$search[$k] = $data_DB;
			}
		}

		foreach ($search as $k => $u) {
			if($u['id'] == $user['id']){
				$relation = 'it_is_me';
				$my_search[] = ['id'=>$u['id'],
								'name'=>$u['name'],
								'last_name'=>$u['last_name'],
								'date_of_birth'=>$u['date_of_birth'],
								'path_to_avatar'=>$u['path_to_avatar'],
								'relation_to_me'=>$relation];
				continue;
			}
			$sql = "SELECT * FROM friends WHERE id = ".$u['id']." OR another_id = ".$u['id'].";";
			$result_query = $conn->query($sql);
			$data_DB = $result_query->fetchAll(PDO::FETCH_ASSOC);
			if(empty($data_DB)){
				$relation = 'add_to_frends';
				$my_search[] = ['id'=>$u['id'],
								'name'=>$u['name'],
								'last_name'=>$u['last_name'],
								'date_of_birth'=>$u['date_of_birth'],
								'path_to_avatar'=>$u['path_to_avatar'],
								'relation_to_me'=>$relation];
				continue;
			}
			foreach ($data_DB as $i => $v) {
				if($v['id']==$user['id'] || $v['another_id']==$user['id']){
					if($v['id']==$user['id']){
						if($v['friend']=='yes' && $v['another_friend']=='yes'){
							$relation = 'delete_frend';
						}
						if($v['friend']=='yes' && $v['another_friend']=='no'){
							$relation = 'cancel_quiry_to_frend';
						}
						if($v['friend']=='no' && $v['another_friend']=='yes'){
							$relation = 'add_to_frends';
						}
						if($v['friend']=='no' && $v['another_friend']=='no'){
							$relation = 'add_to_frends';
						}
						$my_search[$k] = ['id'=>$u['id'],
										'name'=>$u['name'],
										'last_name'=>$u['last_name'],
										'date_of_birth'=>$u['date_of_birth'],
										'path_to_avatar'=>$u['path_to_avatar'],
										'relation_to_me'=>$relation];
						continue(2);
					}else{
						if($v['another_friend']=='yes' && $v['friend']=='yes'){
							$relation = 'delete_frend';
						}
						if($v['another_friend']=='yes' && $v['friend']=='no'){
							$relation = 'cancel_quiry_to_frend';
						}
						if($v['another_friend']=='no' && $v['friend']=='yes'){
							$relation = 'add_to_frends';
						}
						if($v['another_friend']=='no' && $v['friend']=='no'){
							$relation = 'add_to_frends';
						}
						$my_search[$k] = ['id'=>$u['id'],
										'name'=>$u['name'],
										'last_name'=>$u['last_name'],
										'date_of_birth'=>$u['date_of_birth'],
										'path_to_avatar'=>$u['path_to_avatar'],
										'relation_to_me'=>$relation];
						continue(2);
					}
				}else{
					$relation = 'add_to_frends';
					$my_search[$k] = ['id'=>$u['id'],
									'name'=>$u['name'],
									'last_name'=>$u['last_name'],
									'date_of_birth'=>$u['date_of_birth'],
									'path_to_avatar'=>$u['path_to_avatar'],
									'relation_to_me'=>$relation];
				}
			}
		}
		$conn = NULL;
		//damp($my_search);

}}
require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/friends_html.php');
*/