<?php 

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
		$conn = NULL;

		if(empty($search)){
			require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/friends_html.php');
			exit();
		}
		foreach ($search as $v) {
			$arr_search_id[] = $v['id'];
		}

		$sql = "SELECT * FROM friends WHERE";
		foreach ($arr_search_id as $k => $v) {
			$sql .= ' id = '.$v.' OR another_id = '.$v.' ';
			if(isset($arr_search_id[$k + 1])){
				$sql .=' OR ';				
			}
		}
		$conn = conn();
		$result_query = $conn->query($sql);
		$inaccurate_all_friend = $result_query->fetchAll(PDO::FETCH_ASSOC);
		$conn = NULL;
		

		foreach ($inaccurate_all_friend as $u) {
			foreach ($arr_search_id as $i) {
				//нужно выяснить где находится id пользователя которого искали 
				//в $u['id'] или в $u['another_id']
				if($u['id']==$i){
					//проверяю есть ли в $u['another_id'] мой id 
					//для того что бы знать какую кнопку вывести
					if($u['another_id'] == $user['id']){
						//имеют связь нужно выяснить какую
						if($u['friend']=='yes' && $u['another_friend']=='yes'){
							$relation = 'delete_frend';							
						}
						if($u['friend']=='yes' && $u['another_friend']=='no'){
							$relation = 'add_to_frends';
						}
						if($u['friend']=='no' && $u['another_friend']=='yes'){
							$relation = 'cancel_quiry_to_frend';
						}
						if(empty($relation)){
							$relation = 'add_to_frends';
						}
						$all_friend[] = ['id'=>$u['id'],'relation_to_me'=>$relation];
					}else{
						//не имеют связи
						$relation = 'add_to_frends';
						$all_friend[] = ['id'=>$u['id'],'relation_to_me'=>$relation];
					}					
				}
				if($u['another_id']==$i){
					//проверяю есть ли в $u['id'] мой id 
					//для того что бы знать какую кнопку вывести
					if($u['id'] == $user['id']){
						//какую связь я имею с этип пользователем
						if($u['another_friend']=='yes' && $u['friend']=='yes'){
							$relation = 'delete_frend';
						}
						if($u['another_friend']=='yes' && $u['friend']=='no'){
							$relation = 'add_to_frends';
						}
						if($u['another_friend']=='no' && $u['friend']=='yes'){
							$relation = 'cancel_quiry_to_frend';
						}
						if(empty($relation)){
							$relation = 'add_to_frends';
						}
						$all_friend[] = ['id'=>$u['another_id'],'relation_to_me'=>$relation];
					}else{
						$relation = 'add_to_frends';
						$all_friend[] = ['id'=>$u['another_id'],'relation_to_me'=>$relation];
					}
				}
			}
		}
		foreach ($all_friend as $u) {
			foreach ($arr_search_id as $id) {
				if($u['id']==$id){
					$temp[] = $u;
				}
			}
		}
		for($i = 0; $i<count($temp);$i++){
			if($search[$i]['id'] == $temp[$i]['id']){
				$my_search[$i] = [	'id'=>$search[$i]['id'],
									'name'=>$search[$i]['name'],
									'last_name'=>$search[$i]['last_name'],
									'date_of_birth'=>$search[$i]['date_of_birth'],
									'path_to_avatar'=>$search[$i]['path_to_avatar'],
									'relation_to_me'=>$temp[$i]['relation_to_me']];
			}
		}
	}
}
require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/friends_html.php');