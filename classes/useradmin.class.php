<?php
include_once 'db_config.php'; //import db_config.php
include_once 'user.class.php'; //import /classes/user.class.php



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
    public function createUser($registerfullname,$registerusername,$registeremail,$registerpassword,$registerrole)
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
        $error = array();
      
        $user_check_query = "SELECT * FROM users WHERE username='$registerusername' OR email='$registeremail' LIMIT 1";
        require 'db_connection.php';
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);

        $usernameErrorMessage="Registration Unsuccessful Username already exists";
        $emailErrorMessage="Registration Unsuccessfu Email already exists";

        if ($user) { // if user exists
            if ($user['username'] === $registerusername) {
                array_push($error, "Username already exists");
                echo "<script type='text/javascript'>alert('$usernameErrorMessage');</script>;";
                return false;

            }
        
            if ($user['email'] === $registeremail) {
                array_push($error, "email already exists");
                echo "<script type='text/javascript'>alert('$emailErrorMessage');</script>;";
                return false;
            }
        }
        //resgister user if there are no errors in the registration form
        if (count($error) == 0) {
            $registerpassword = md5($registerpassword);
        
            $sql="SELECT * FROM users WHERE username='$registerusername' OR email='$registeremail'";
            
            $sql="INSERT INTO users(fullname,username,email,password,role,status) 
                                        VALUES('$registerfullname','$registerusername','$registeremail','$registerpassword',' $registerrole',1 )";
            mysqli_query($conn, $sql);

            echo "<script type='text/javascript'>alert('Registration successful');</script>;";
            
        }
    }

    
    

    public function suspendUser()
    {
        if (isset($_POST['username'])) {
            $username = $_POST['username'];
            //echo $username;
            $sql="UPDATE USERS SET status= 0  WHERE username= '$username'";
            //echo $sql;
            $result=mysqli_query($this->db, $sql);
            if ($result === true) {
               // echo "Record updated successfully";
               header("location:userAdmin.php");
            } else {
                echo "Error updating record: " . $this->db->error;
            }
        } else {
            return false;
        }
    }
   
    private function deleteUser()
    {
    }
}

?>
