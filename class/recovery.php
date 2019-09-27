<?php

class recovery{
	private $login;
	private $secret_question;
	private $answer;

	public function __construct($login){
		$this->login = $login;		
		$sql = "SELECT secret_question,answer FROM registration_data WHERE login = ?;";
		$DB = new DB();
		$registration_data = $DB->execute_fetch($sql,[$this->login]);
		$this->secret_question = $registration_data->secret_question;
		$this->answer = $registration_data->answer;
		
	}

	public function check_login(){
		$sql = "SELECT * FROM registration_data WHERE login = ? ;";
		$DB = new DB;
		$result_execute = $DB->execute_fetch($sql,[$this->login]);
		if(empty($result_execute)){
			return false;
		}else{
			return true;
		}
	}
	public function check_answer($answer){
		if($this->answer == $answer){
			return true;
		}
		return false;
	}
	public function check_password($password_1,$password_2){
		if($this->validation_password($password_1,$password_2)){
			return true;
		}
		return false;
	}
	public function update_password($password_1){
		$sql = "UPDATE registration_data SET password = ? WHERE login = '".$this->login."';";
		$DB = new DB;
		$password = md5($password_1);
		$DB->execute($sql,[$password]);
	}
	public function get_id_by_login(){
		$sql = "SELECT id FROM registration_data WHERE login = ?";
		$DB = new DB;
		$registration_data = $DB->execute_fetch($sql,[$this->login]);
		return $registration_data->id;
	}
	public function get_secret_question(){
		return $this->secret_question;
	}
	private function validation_password($password_1,$password_2){		
		if(empty($password_1)){
			return false;
		}
		if(!( 2 < strlen($password_1) && strlen($password_1) < 17)){
			return false;
		}
		if($password_1!=$password_2){
			return false;
		}
		return true;
	}
}