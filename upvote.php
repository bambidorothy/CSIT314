<?php

require_once 'db_config.php';
require_once 'classes/student.class.php';
require "db_connection.php";
$student= new Student();
$ansid= $_GET['ans_id'];
$postid = $_GET['post_id'];
$student->upvoteAns($ansid,$postid);

?>