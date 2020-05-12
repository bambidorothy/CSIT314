<?php
require_once 'db_config.php';
require_once 'classes/user.class.php';
session_start();
$id = $_SESSION['id'];
$student = new Student();
$student->updatePost($id);
?>