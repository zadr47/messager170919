<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/include/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/include/function.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/include/session.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/class/DB.php');

create_table_registration_data();
create_table_data_user();
create_table_friends();
create_table_chats();
create_table_message();