<?php
include_once 'user.class.php'; //import /classes/user.class.php
include_once 'db_config.php';
include_once 'db_connection.php';


class Student extends User { //create Student class


    public function createPost($id,$question,$postDate,$postTime)
    {       
        $sql="INSERT INTO post(users_id,content,upvote,date,time) 
                                    VALUES('$id','$question',0,'$postDate','$postTime')";

        mysqli_query($this->db, $sql);
    
        echo "<script type='text/javascript'>alert('Question has been posted successfully');</script>;";

    }

}
