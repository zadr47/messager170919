<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/include.php');

$conn = conn();


$sql = "DROP TABLE data_user";
$conn->query($sql);

$sql = "DROP TABLE registration_data";
$conn->query($sql);

$sql = "DROP TABLE friends";
$conn->query($sql);


$conn = NULL;

$_SESSION['user_id'] = NULL;

header('Location:/');
