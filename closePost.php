<?php
require_once 'db_config.php';
require_once 'classes/student.class.php';
$post_id = $_GET['id'];
$studentuser = new Student();
$studentuser->markPostClose($post_id);
?>