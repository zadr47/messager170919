<?php
	
require_once($_SERVER['DOCUMENT_ROOT'].'/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/function.php');	
require_once($_SERVER['DOCUMENT_ROOT'].'/session.php');

is_access();

$user = $_SESSION['connection'];

$conn = conn();

$sql = "SELECT * FROM data_user WHERE id = ".$user['id'].";";
$result_query = $conn->query($sql);
$data_user = $result_query->fetch(PDO::FETCH_ASSOC);


$sql = "SELECT * FROM friends WHERE id = ".$user['id']." OR another_id = ".$user['id'].";";
$result_query = $conn->query($sql);
$inaccurate_all_friend = $result_query->fetchAll(PDO::FETCH_ASSOC);
$conn = NULL;

for($i = 0;$i<count($inaccurate_all_friend);$i++){
	$u = $inaccurate_all_friend[$i];
	if($u['id']!=$user['id']){
		$all_friend[$i]['id'] = $u['another_id'];
		$all_friend[$i]['friend'] = $u['another_friend'];
		$all_friend[$i]['another_id'] = $u['id'];
		$all_friend[$i]['another_friend'] = $u['friend'];
	}else{
		$all_friend[$i] = $u;
	}
}

$conn = conn();
foreach ($all_friend as $u) {
	if($u['friend']=='yes' && $u['another_friend']=='yes'){
		$sql = "SELECT * FROM data_user WHERE id = ".$u['another_id'].";";
		$result_query = $conn->query($sql);
		$data_u = $result_query->fetch(PDO::FETCH_ASSOC);
		$my_friends[] = $data_u;
	}
	if($u['friend']=='no' && $u['another_friend']=='yes'){
		//подписчики
		$sql = "SELECT * FROM data_user WHERE id = ".$u['another_id'].";";
		$result_query = $conn->query($sql);
		$data_u = $result_query->fetch(PDO::FETCH_ASSOC);
		$my_subscribers[] = $data_u;
	}
	if($u['friend'] =='yes' && $u['another_friend'] == 'no'){
		//подписки
		$sql = "SELECT * FROM data_user WHERE id = ".$u['another_id'].";";
		$result_query = $conn->query($sql);
		$data_u = $result_query->fetch(PDO::FETCH_ASSOC);
		$my_subscriptions[] = $data_u;
	}
}

$conn = NULL;

$data = $_REQUEST;

require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/friends_html.php');
