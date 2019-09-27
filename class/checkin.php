<?php

class checkin{
	private $login;
	private $password_1;
	private $password_2;

	public function __construct($login,$password_1,$password_2){
		$this->login = htmlspecialchars(trim($login));
		$this->password_1 = htmlspecialchars(trim($password_1));
		$this->password_2 = htmlspecialchars(trim($password_2));
	}
	private function check_login(){
		$sql = "SELECT * FROM registration_data WHERE login = ? ;";
		$DB = new DB;
		$result_execute = $DB->execute_fetch($sql,[$this->login]);
		if(empty($result_execute)){
			return true;
		}else{
			return false;
		}
	}
	private function validation_login(){
		if(empty($this->login)){
			return false;
		}
		if(!( 3 < strlen($this->login) && strlen($this->login) < 17)){
			return false;
		}
		return true;
	}
	private function validation_password(){		
		if(empty($this->password_1)){
			return false;
		}
		if(!( 2 < strlen($this->password_1) && strlen($this->password_1) < 17)){
			return false;
		}
		if($this->password_1!=$this->password_2){
			return false;
		}
		return true;
	}
	public function can_reg(){
		if($this->validation_login()){
			if($this->check_login()){
				if($this->validation_password()){	
					return true;					
				}
			}
		}
		return false;
	}
	public function reg(){
		$sql = "SELECT id FROM registration_data";
		$DB = new DB;
		$arrID = $DB->query_fetchAll($sql);
		$max_id = 0;
		foreach($arrID as $k => $v){
			foreach ($v as $id) {
				if($max_id < $id){
					$max_id = $id;
				}
			}
		}
		$id = $max_id;
		$id++;
		$time = time();
		$sql = "INSERT INTO registration_data (id,login,password,date_reg) VALUES (?,?,?,?)";
		$DB->execute($sql,[$id,$this->login,md5($this->password_1),$time]);
		$path_to_avatar = '/img/standard/standard_avatar.jpg';
		$sql = "INSERT INTO data_user (id,name,last_name,path_to_avatar) VALUES (".$id.", '".$this->login."', '".$this->login."', '".$path_to_avatar."');";
		$DB->query($sql);
		return $id;
	}
}