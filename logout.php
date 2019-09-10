<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/session.php');

$_SESSION['connection'] = NULL;
header('Location:/');