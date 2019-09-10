<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/function.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/session.php');

$data = $_REQUEST;

if(isset($data['do_question'])){
	$error = [];
	if(empty($data['question'])){
		$error[] = 'Вы не выбрали вопрос!';
	}
	if(empty($data['answer'])){
		$error[] = 'Вы не ответили на вопрос!';
	}
	if(empty($error)){
		$id = $_SESSION['connection']['id'];
		$sql = "UPDATE registration_data SET secret_question = ? , answer = ? WHERE id = $id";
		$conn = conn();
		$snapshot = $conn->prepare($sql);
		$snapshot->execute([$data['question'],$data['answer']]);
		$conn = NULL;
		$_SESSION['connection']['secret_question'] = $data['question'];
		$_SESSION['connection']['answer'] = $data['answer'];
		header('Location:/');
	}else{
		$message = $error[0];
		require_once($_SERVER['DOCUMENT_ROOT'].'/secret_question_html.php');
	}
}
require_once($_SERVER['DOCUMENT_ROOT'].'/secret_question_html.php');