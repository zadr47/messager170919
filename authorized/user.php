<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/function.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/session.php');

is_access();

$user = $_SESSION['connection'];
$data = $_REQUEST;
$id_another_user = htmlspecialchars($_REQUEST['user_id']);

if($user['id']==$id_another_user){
	header('Location:/');
}
$sql = "SELECT * FROM data_user WHERE id = ".$id_another_user.";";
$conn = conn();
$result_query = $conn->query($sql);
$data_another_user = $result_query->fetch(PDO::FETCH_ASSOC);


$sql = "SELECT * FROM friends WHERE id = ".$user['id']." AND another_id = ? OR id = ? AND another_id= ".$user['id'];
$snapshot = $conn->prepare($sql);
$snapshot->execute([$data_another_user['id'],$data_another_user['id']]);
$data_DB = $snapshot->fetch(PDO::FETCH_ASSOC);
$conn = NULL;
if($data_DB['id']==$user['id'] || $data_DB['another_id'] == $user['id']){
	//вы с этим userom как-то связаны нужно выяснить как
	if($data_DB['id']==$data_another_user['id']){
		if($data_DB['friend'] == 'yes' && $data_DB['another_friend'] == 'yes'){
			$relation = 'delete_frend';
		}
		if($data_DB['friend'] == 'yes' && $data_DB['another_friend'] == 'no'){
			$relation = 'add_to_frends';
		}
		if($data_DB['friend'] == 'no' && $data_DB['another_friend'] == 'yes'){
			$relation = 'cancel_quiry_to_frend';
		}
		if($data_DB['friend'] == 'no' && $data_DB['another_friend'] == 'no'){
			$relation = 'add_to_frends';
		}
	}else{
		if($data_DB['another_friend'] == 'yes' && $data_DB['friend'] == 'yes'){
			$relation = 'delete_frend';
		}
		if($data_DB['another_friend'] == 'yes' && $data_DB['friend'] == 'no'){
			$relation = 'add_to_frends';
		}
		if($data_DB['another_friend'] == 'no' && $data_DB['friend'] == 'yes'){
			$relation = 'cancel_quiry_to_frend';
		}
		if($data_DB['another_friend'] == 'no' && $data_DB['friend'] == 'no'){
			$relation = 'add_to_frends';
		}
	}
}else{
	// ни как не связаны
	$relation = 'add_to_frends';
}
$temp = $data_another_user;

$data_another_user = [	'id'=>$temp['id'],
						'name'=>$temp['name'],
						'last_name'=>$temp['last_name'],
						'date_of_birth'=>$temp['date_of_birth'],
						'path_to_avatar'=>$temp['path_to_avatar'],
						'relation_to_me'=>$relation];
require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/user_html.php');


