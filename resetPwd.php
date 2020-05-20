<?php
require_once 'db_config.php';
require_once 'classes/user.class.php';
$user = new User();
$user->resetPwd();
?>