<?php
include_once 'db_config.php'; //import db_config.php
include_once 'user.class.php'; //import /classes/user.class.php



class UserAdmin extends User
{ //create UserAdmin class

    //create User Account
    public function createUser($registerfullname,$registerusername,$registeremail,$registerpassword,$registerrole)
    {
        $error = array();
      
        $user_check_query = "SELECT * FROM users WHERE username='$registerusername' OR email='$registeremail' LIMIT 1";
        require 'db_connection.php';
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);

        $usernameErrorMessage="Registration Unsuccessful Username already exists";
        $emailErrorMessage="Registration Unsuccessful Email already exists";

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
        $newregisterrole ;
        //resgister user if there are no errors in the registration form
        if (count($error) == 0) {
            //$registerpassword = md5($registerpassword);

            $sql="SELECT * FROM users WHERE username='$registerusername' OR email='$registeremail'";
            
            $sql="INSERT INTO users(fullname,username,email,password,role,status) 
                                        VALUES('$registerfullname','$registerusername','$registeremail','$registerpassword','$registerrole',1 )";
            mysqli_query($conn, $sql);

            echo "<script type='text/javascript'>alert('Registration successful');</script>;";
            
        }
    }

    
    
    //suspend user func upon posting full name of user account to be suspended
    public function suspendUser()
    {
        if (isset($_POST['fullname'])) {
            $fullname = $_POST['fullname'];
            //echo $fullname;
            $sql="UPDATE USERS SET status= 0  WHERE fullname= '$fullname'";
            //echo $sql;
            $result=mysqli_query($this->db, $sql);
            if ($result === true) {
                $message = "User account suspended successfully!";
                echo "<script type='text/javascript'>alert('$message');</script>"; //do javascript alert upon successful suspension
                echo "<script>window.open('userAdmin.php', '_self');</script>"; //redirect back to useradmin.php
            } else {
                echo "Error updating record: " . $this->db->error;
            }
        } else {
            return false;
        }
    }
    //Restore user func upon posting full name of user account to be restored
    public function restoreUser()
    {
        if (isset($_POST['fullname'])) {
            $fullname = $_POST['fullname'];
            echo $fullname;
            $sql="UPDATE USERS SET status= 1  WHERE fullname= '$fullname'";
            //echo $sql;
            $result=mysqli_query($this->db, $sql);
            if ($result === true) {
                $message = "User account restored successfully!";
                echo "<script type='text/javascript'>alert('$message');</script>"; //do javascript alert upon successful restoration
                echo "<script>window.open('userAdmin.php', '_self');</script>";    //redirect back to useradmin.php
            } else {
                echo "Error updating record: " . $this->db->error;
            }
        } else {
            return false;
        }
    }
}

?>
