<?php
require_once 'db_config.php';
require_once 'classes/student.class.php';
require "db_connection.php";
        $ansid= $_GET['ans_id'];
        $postid = $_GET['post_id'];
        $sql="UPDATE ANSWERS SET upvote = upvote + 1 WHERE id='$ansid'";
        $result=mysqli_query($conn, $sql);
        if ($result === true) {
            //$updatesql="UPDATE USERS SET participation = participation + 1 WHERE id='$id'";
            //$resultupdate=mysqli_query($this->db, $updatesql);
            $message = "Upvoted successfully!";
            echo "<script type='text/javascript'>alert('$message');</script>"; //do javascript alert upon successful suspension
            echo "<script>window.open('detailPost.php?post_id=".$postid."', '_self');</script>"; //redirect back to student.php
        } else {
            echo "Error updating record: " . $conn->error;
        }

?>