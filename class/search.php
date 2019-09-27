<?php

class search{

	private $table;
	private $key;
	private $str;

	public function __construct($table,$key,$str){
		$this->table = $table;
		$this->key = $key;
		$this->str = htmlspecialchars(trim($str));
	}
	public function do_search(){
		if(empty($this->str)){
			return false;
		}
		$arr_str = explode(' ' , $this->str);

		$sql = "SELECT * FROM ".$this->table." WHERE ";

		if(is_array($this->key)){
			foreach ($arr_str as $i => $s) {
				foreach ($this->key as $k => $v) {
					$sql .= " ".$v." LIKE ? ";
					$arr_to_execute[] = '%'.$s.'%';
					if(isset($this->key[$k+1])){
						$sql .= " OR ";
					}					
				}
				if(isset($arr_str[$i+1])){
						$sql .= " OR ";
				}
			}
		}else{
			foreach ($arr_str as $k => $v) {
				$sql .= " ".$this->key." LIKE ? ";
				$arr_to_execute[] = '%'.$v.'%';
				if(isset($arr_str[$k + 1])){
					$sql .= " OR ";
				}
			}
		}
		$DB = new DB;
		$data_DB = $DB->execute_fetchAll($sql,$arr_to_execute);
		return $data_DB;
	}
}