<?php

class DB{
	public function query($sql){
		$conn = conn();
		$result_query = $conn->query($sql);
		$conn = NULL;
		return $result_query;
	}
	public function query_fetch($sql){
		$conn = conn();
		$result_query = $conn->query($sql);
		$data_DB = $result_query->fetch(PDO::FETCH_OBJ);
		$conn = NULL;
		return $data_DB;
	}
	public function query_fetchAll($sql){
		$conn = conn();
		$result_query = $conn->query($sql);
		$data_DB = $result_query->fetchAll(PDO::FETCH_OBJ);
		$conn = NULL;
		return $data_DB;
	}
	public function execute($sql,$values){
		$conn = conn();
		$snapshot = $conn->prepare($sql);
		$result_execute = $snapshot->execute($values);
		$conn = NULL;
		return $result_execute;
	}
	public function execute_fetch($sql,$values){
		$conn = conn();
		$snapshot = $conn->prepare($sql);
		$snapshot->execute($values);
		$data_DB = $snapshot->fetch(PDO::FETCH_OBJ);
		$conn = NULL;
		return $data_DB;
	}
	public function execute_fetchAll($sql,$values){
		$conn = conn();
		$snapshot = $conn->prepare($sql);
		$snapshot->execute($values);
		$data_DB = $snapshot->fetchAll(PDO::FETCH_OBJ);
		$conn = NULL;
		return $data_DB;
	}
}