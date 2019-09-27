<?php

class login{
	private $login;
	private $password;

	public function __construct($login,$password){
		$this->login = htmlspecialchars(trim($login));
		$this->password = htmlspecialchars(trim($password));
	}
	private function check_login(){
		$sql = "SELECT * FROM registration_data WHERE login = ? ;";
		$DB = new DB;
		$result_execute = $DB->execute_fetch($sql,[$this->login]);
		if(!empty($result_execute)){
			return true;
		}else{
			return false;
		}
	}
	private function check_password(){
		$sql = "SELECT * FROM registration_data WHERE login = ?;";
		$DB = new DB;
		$result_execute = $DB->execute_fetch($sql,[$this->login]);
		if(md5($this->password)==$result_execute->password){
			return true;
		}else{
			return false;
		}
	}
	public function entry(){
		if($this->check_login()){
			if($this->check_password()){
				return true;
			}
		}
		return false;
	}
	public	function get_id(){
		$sql = "SELECT id FROM registration_data WHERE login = ?;";
		$DB = new DB;		
		$result_execute = $DB->execute_fetch($sql,[$this->login]);
		return $result_execute->id;
	}
}