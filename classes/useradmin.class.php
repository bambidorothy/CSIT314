<?php
include_once 'user.class.php'; //import /classes/user.class.php
include_once '../db_config.php';

class UserAdmin extends User
{ //create UserAdmin class
    //get useradmin profile

    //get list of users
    private function getUsers()
    {
        $sql="SELECT * from users";
        $result = mysqli_query($this->db, $sql);
        while ($row = mysql_fetch_array($result)) {
            echo $row['fullname']; // Print a single column data
            echo print_r($row);       // Print the entire row data
        }
    }
    //create User Account
    private function createUser()
    {
        $sql="SELECT * FROM users WHERE username='$username' OR email='$email'";

        //checking if the user exists in db
        $check =  $this->db->query($sql) ;
        $count_row = $check->num_rows;

        //if user does not exist then insert to the db user table
        if ($count_row == 0) {
            $sql1="INSERT INTO `users`(`id`, `fullname`, `username`, `email`, `password`, `role`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6])";
            $result = mysqli_query($this->db, $sql1) or die(mysqli_connect_errno()."Data cannot be inserted");
            return $result;
        } else {
            return false;
        }
    }
    //delete User Account
    private function deleteUser()
    {
    }
}
