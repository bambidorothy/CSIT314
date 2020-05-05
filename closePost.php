<?php
include 'classes/student.class.php';
$post_id = $_GET['post_id'];
$student = new Student();
$student->markPostClose($post_id);
?>