<?php
include_once 'user.class.php'; //import /classes/user.class.php
include_once 'db_config.php';
include_once 'db_connection.php';

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
    public function createUser($fullname,$username,$email,$password,$role)
    {
       /* $sql="SELECT * FROM users WHERE username='$username' OR email='$email'";

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
        }*/
        if(empty($fullname)){
            echo "Fullname is required !";
            return false;
        }
        if(empty($username)){
            echo "Username is required !";
            return false;
        }
        if(empty($email)){
            echo "Email is required !";
            return false;
        }
        if(empty($password)){
            echo "Password is required !";
            return false;
        }
    
        $errors = array();

        $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
        require 'db_connection.php';
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);

        if ($user) { // if user exists
            if ($user['username'] === $username) {
              array_push($errors, "Username already exists");
            }
        
            if ($user['email'] === $email) {
              array_push($errors, "email already exists");
            }
          }
//resgister user if there are no errors in the registration form
        if (count($errors) == 0){
             $password = md5($password);
        
                $sql="SELECT * FROM users WHERE username='$username' OR email='$email'";
            
                $sql="INSERT INTO users(fullname,username,email,password,role) 
                                        VALUES('$fullname','$username','$email','$password',' $role' )"; 
        mysqli_query($conn,$sql);
        
        }

    
    

    }
   
    private function deleteUser()
    {
    }
}
