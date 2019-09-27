<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/class/user.php');

$data = $_REQUEST;

$user = new user($_SESSION['user_id']);

if(isset($data['do_question'])){
	if($user->validation_secret_question($data['question'],$data['answer'])){
		$user->add_secret_question();
		header('Location:/');
	}else{
		$message = "<b>Ошибка!</b>
					<p>Выберите вопрос!</b>
					<p>Ответьте на выбраный вопрос!</p>";
		require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/secret_question/secret_question_html.php');
	}
}
require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/secret_question/secret_question_html.php');