<?php

class user{
	private $id;
	private $secret_question;
	private $answer;
	private $password;
	private $login;
	private $name;
	private $last_name;
	private $path_to_avatar;
	private $date_of_birth;
	private $date_reg;

	public function __construct($id){
		$DB = new DB;
		$sql = "SELECT * FROM registration_data WHERE id = ".$id.";";

		$registration_data = $DB->query_fetch($sql);

		$sql = "SELECT * FROM data_user WHERE id = ".$id.";";
		$data_user = $DB->query_fetch($sql);

		$this->id = $registration_data->id;
		$this->password = $registration_data->password;
		$this->login = $registration_data->login;
		$this->date_reg = $registration_data->date_reg;
		$this->secret_question = $registration_data->secret_question;
		$this->answer = $registration_data->answer;
		
		$this->name = $data_user->name;
		$this->last_name = $data_user->last_name;
		$this->date_of_birth = $data_user->date_of_birth;
		$this->path_to_avatar = $data_user->path_to_avatar;
	}
	public function first_connection(){
		if(empty($this->secret_question)){
			return true;
		}else{
			return false;
		}
	}
	public function validation_secret_question($secret_question,$answer){
		$this->secret_question = htmlspecialchars(trim($secret_question));
		$this->answer = htmlspecialchars(trim($answer));
		if(empty($this->secret_question)){
			return false;
		}
		if(empty($this->answer)){
			return false;
		}
		return true;
	}
	public function add_secret_question(){
		$sql = "UPDATE registration_data SET secret_question = ? , answer = ? WHERE id = ".$this->id.";";
		$DB = new DB;
		$DB->execute($sql,[$this->secret_question,$this->answer]);
	}
	public function get_id(){
		return $this->id;
	}
	public function get_name(){
		return $this->name;
	}
	public function get_last_name(){
		return $this->last_name;
	}
	public function get_path_to_avatar(){
		return $this->path_to_avatar;
	}
	public function get_date_of_birth(){
		return $this->date_of_birth;
	}
	public function get_date_reg(){
		return $this->date_reg;
	}
	public function get_login(){
		return $this->login;
	}
	public function get_secret_question(){
		return $this->secret_question;
	}
	public function get_answer(){
		return $this->answer;
	}
	public function update_info_of_user($name,$last_name,$date_of_birth){
		$name = htmlspecialchars(trim($name));
		$last_name = htmlspecialchars(trim($last_name));

		$arr_info_update = [];

		if(!empty($date_of_birth)){				
			$arr_date = explode('-',$date_of_birth);
			$day = $arr_date[2];
			$month = $arr_date[1];
			$year = $arr_date[0];
			$date_of_birth = mktime(0,0,0,$month,$day,$year);
			$this->date_of_birth = $date_of_birth;
			$arr_info_update['date_of_birth'] = $date_of_birth;
		}
		if(!empty($name)){
			$arr_info_update['name'] = $name;
			$this->name = $name;
		}
		if(!empty($last_name)){
			$arr_info_update['last_name'] = $last_name;
			$this->last_name = $last_name;
		}
		if(!empty($arr_info_update)){

			$sql = "UPDATE data_user SET ";
			$i = count($arr_info_update);
			foreach ($arr_info_update as $k => $v) {
				$sql .= " ".$k." = ? ";
				$i--;
				if($i>0){
					$sql .= ' , ';
				}
			}
			$sql .= " WHERE id = ".$this->id.";";

			$arr_info_update = array_values($arr_info_update);

			$DB = new DB;
			$DB->execute($sql,$arr_info_update);
		}
	}
	public function update_avater_user($data_avatar){
		if($data_avatar['tmp_name']==''){
			return false;
		}
		$avatar = $_FILES['avatar'];

		$path_to_img = $_SERVER['DOCUMENT_ROOT'].'/img';
		if(!file_exists($path_to_img)){
			mkdir($path_to_img) or die ('не удалось создать папку "img"!');
		}
		$path_to_user_id = $_SERVER['DOCUMENT_ROOT'].'/img/user_'.$this->id;
		if(!file_exists($path_to_user_id)){
			mkdir($path_to_user_id) or die ('не удалось создать папку "user_id"');
		}

		$path_to_standard_avatar = '/img/standard/standard_avatar.jpg';
		if($path_to_standard_avatar == $this->path_to_avatar){
			$id_avatar = 1;
		}else{	
			preg_match('/_([0-9]+)\./sx',$this->path_to_avatar,$arrPath_to_avatar);
			$id_avatar = $arrPath_to_avatar[1];
			$id_avatar++;
		}

		$filename = $data_avatar['tmp_name'];
		$path_to_user_avatar = $_SERVER['DOCUMENT_ROOT'].'/img/user_'.$this->id.'/avatar_'.$id_avatar.'.jpg';
		move_uploaded_file($filename, $path_to_user_avatar);

		$path_to_user_avatar = '/img/user_'.$this->id.'/avatar_'.$id_avatar.'.jpg';
		$sql = "UPDATE data_user SET path_to_avatar = '".$path_to_user_avatar."' WHERE id = ".$this->id.";";
		$DB = new DB;
		$DB->query($sql);
	}
	public function is_friends(){
		$sql = "SELECT * FROM friends WHERE id = ".$this->id." AND relationship = 'friends';";
		$DB = new DB;
		$arr_friends = $DB->query_fetchAll($sql);
		if(!empty($arr_friends)){
			return true;
		}else{
			return false;
		}
	}
	public function get_arr_friends(){
		$sql = "SELECT * FROM friends WHERE id = ".$this->id." AND relationship = 'friends';";
		$DB = new DB;
		$arr_friends = $DB->query_fetchAll($sql);
		return $arr_friends;
	}
	public function get_arr_fans(){// id 1 another_id 2 relationship fan (id 1 подписан на id 2)
		$sql = "SELECT * FROM friends WHERE id = ".$this->id." AND relationship = 'not_fan';";
		$DB = new DB;
		$arr_fans = $DB->query_fetchAll($sql);
		return $arr_fans;
	}
	public function get_arr_not_fans(){
		$sql = "SELECT * FROM friends WHERE id = ".$this->id." AND relationship = 'fan';";
		$DB = new DB;
		$arr_not_fans = $DB->query_fetchAll($sql);
		return $arr_not_fans;
	}
	public function do_make_with_friend($id){
		if($id == $this->id){
			return false;
		}
		$DB = new DB;
		$sql = "SELECT * FROM friends WHERE id = ".$this->id." AND another_id = ".$id.";";
		$data_DB = $DB->query_fetch($sql);
		if(!empty($data_DB)){
			switch ($data_DB->relationship) {
				case 'friends':
						$user_relationship = 'not_fan';
						$another_user_relationship = 'fan';
					break;
				case 'not_friends':
						$user_relationship = 'fan';
						$another_user_relationship = 'not_fan';
					break;
				case 'fan':
						$user_relationship = 'not_friends';
						$another_user_relationship = 'not_friends';
					break;
				case 'not_fan':
						$user_relationship = 'friends';
						$another_user_relationship = 'friends';
					break;
			}
			$sql = "UPDATE friends SET relationship = '".$user_relationship."' WHERE id = ".$this->id." AND another_id = ".$id.";";
			$DB->query($sql);
			$sql = "UPDATE friends SET relationship = '".$another_user_relationship."' WHERE id = ".$id." AND another_id = ".$this->id.";";
			$DB->query($sql);
		}else{
			$sql = "INSERT INTO friends (id,another_id,relationship) 
					VALUES (".$this->id.",".$id.",'fan');";
			$DB->query($sql);
			$sql = "INSERT INTO friends (id,another_id,relationship) 
					VALUES (".$id.",".$this->id.",'not_fan');";
			$DB->query($sql);

		}
	}
	public function get_relationship_to($id){
		$DB = new DB;
		$sql = "SELECT relationship FROM friends WHERE id = ".$this->id." AND another_id = ".$id.";";
		$result_DB = $DB->query_fetch($sql);
		return $result_DB->relationship;
	}
	public function get_chats(){
		$DB = new DB;
		$sql = "SELECT * FROM chats WHERE id = ".$this->id." OR another_id = ".$this->id." ORDER BY time_last_change DESC";
		$my_chats = $DB->query_fetchAll($sql);
		if(empty($my_chats)){
			return false;
		}
		foreach ($my_chats as $k => $v) {
			if($v->id==$this->id){
				$chats[] = $v;
			}else{
				$chats[] = new chat($v->id_chat,$v->another_id,$v->id,$v->time_last_change);
			}
						
		}
		return $chats;
	}
	public function create_new_chat($id){
		$DB = new DB;
		$sql = "SELECT * FROM chats ORDER BY id_chat DESC";
		$max_id = $DB->query($sql);
		if(empty($max_id)){
			$id_chat = 1;
		}else{
			$id_chat = ++$max_id;
		}
		$sql = "INSERT INTO chats (id_chats,id,another_id,time_last_change) VALUES 
			(".$id_chat.",".$this->id.",".$id.",".time().");";
		$DB->query($sql);
	}
	public function is_chat($id){
		$DB = new DB;
		$sql = "SELECT * FROM chats WHERE id = ".$this->id." AND another_id = ".$id." OR another_id = ".$this->id." AND id = ".$id.";";
		$chat = $DB->query_fetch($sql);
		if(!empty($chat)){
			return true;
		}else{
			return false;
		}
	}
	public function get_id_chat($id){
		$DB = new DB;
		$sql = "SELECT id_chat FROM chats WHERE id = ".$this->id." AND another_id = ".$id." OR id = ".$id." AND another_id = ".$this->id.";";
		$data_DB = $DB->query_fetch($sql);
		$chat = $data_DB->id_chat;
		return $chat;
	}
	public function get_chat($id){
		$id_chat = $this->get_id_chat($id);
		$DB = new DB;
		$sql = "SELECT * FROM message WHERE id_chat = ".$id_chat." ORDER BY time_add ASC;";
		$arr_message = $DB->query_fetchAll($sql);
		return $arr_message;
	}
	public function add_message($id,$message){
		if(!$this->is_chat($id)){
			$this->create_new_chat($id);
		}
		$message = htmlspecialchars(trim($message));
		$id_chat = $this->get_id_chat($id);
		$DB = new DB;
		$sql = "INSERT INTO message (id_chat,my_id,another_id,id,message,time_add) VALUES 
			(".$id_chat.",".$this->id.",?,".$this->id.",?,".time().");";
		$DB->execute($sql,[$id,$message]);
	}
}
class chat{
	public $id_chat;
	public $id;
	public $another_id;
	public $time_last_change;

	public function __construct($id_chat,$id,$another_id,$time_last_change){
		$this->id_chat = $id_chat;
		$this->id = $id;
		$this->another_id = $another_id;
		$this->time_last_change = $time_last_change;
	}

}