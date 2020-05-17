<?php
require_once 'db_config.php';
require_once 'classes/student.class.php';
$post_id = $_GET['post_id'];
$studentuser = new Student();
$studentuser->upvoteAns($id);
?>