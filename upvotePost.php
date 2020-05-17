<?php
session_start();
$id = $_SESSION['id'];
require_once 'db_config.php';
require_once 'classes/student.class.php';
require "db_connection.php";
$student= new Student();
$postid = $_GET['post_id'];
$student->upvotePost($id,$postid);

?>