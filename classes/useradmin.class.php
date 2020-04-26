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
        while($row = mysql_fetch_array($result)) {
            echo $row['fullname']; // Print a single column data
            echo print_r($row);       // Print the entire row data
        }
    }
    //create User Account
    private function createUser() {

    }
    //delete User Account
    private function deleteUser() {

    }
}
?>