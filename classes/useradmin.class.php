<?php
include_once 'user.class.php'; //import /classes/user.class.php
include_once '../db_config.php';

class UserAdmin extends User
{ //create UserAdmin class
    //get useradmin profile

    //get list of users
    public function getUsers()
    {
        $sql="SELECT * from users";
        $result = mysqli_query($this->db, $sql);
        while($row = mysql_fetch_array($result)) {
            echo $row['fullname']; // Print a single column data
            echo print_r($row);       // Print the entire row data
            
                }
    }
    //get user fullname, username, email and role
    public function getAccount() {
        $sql="SELECT fullname, username, email, role from users";
        $result = mysqli_query($this->db, $sql);
        if ($result-> num_rows > 0) {
            while ($row = $result-> fetch_assoc()) {
                echo "<tr><td>". $row["fullname"] ."</td><td>". $row["username"] ."</td><td>". $row["email"] ."</td><td>". $row["role"] ."</td></tr>";
            }
            echo "</table>";
        }
        else {
            echo "0 result"; 
    }
}
    //create User Account
    public function createUser() {

    }
    //delete User Account
    public function deleteUser() {

    }
}
?>