<?php 

require_once($_SERVER['DOCUMENT_ROOT'].'/include.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/class/user.php');

$user = new user($_SESSION['user_id']);

$data = $_REQUEST;

if(isset($data['do_editing_avatar'])){

	$user->update_avater_user($_FILES['avatar']);
	header('Location:/');
}
require_once($_SERVER['DOCUMENT_ROOT'].'/authorized/editing/avatar_html.php');		





