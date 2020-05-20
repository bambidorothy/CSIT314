<?php

class User
{//create User class

    public function __construct() // constructor runs when object is created
    {
        $this->db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        if (mysqli_connect_errno()) { //if fail to connect to database echo error
            echo "Error: Could not connect to database.";
            exit;
        }
    }

    /* for login process */
    public function validate_login($email, $password) //get email & password input from login.php form
    {
        $sql="SELECT id from users WHERE email='$email' and password='$password'"; //sql statement which retrieves id from users table where email and password match

        //checking if the id is available in the table
        $result = mysqli_query($this->db, $sql); //query out user table id from db and store in $result
        $user_data = mysqli_fetch_array($result); //fetches a result row as an associative array in $user_data
        $count_row = $result->num_rows;

        if ($count_row == 1) { //if array is present with one row
            // creates and stores a session
            $_SESSION['login'] = true; //session login is true
            $_SESSION['id'] = $user_data['id']; //stores user id into a session variable 'id'
            return true;
        } else {
            return false;
        }
    }
    /*get user account status */
    public function get_status($id)
    {
        $sql="SELECT status FROM users WHERE id = $id";
        $result = mysqli_query($this->db, $sql);
        $user_data = mysqli_fetch_array($result);
        //echo $user_data['status'];
        return $user_data['status'];
    }

    /*get user fullname*/
    public function get_fullname($id)
    {
        $sql="SELECT fullname FROM users WHERE id = $id";
        $result = mysqli_query($this->db, $sql);
        $user_data = mysqli_fetch_array($result);
        echo $user_data['fullname'];
    }

    /*get user email*/
    public function get_email($id)
    {
        $sql="SELECT email FROM users WHERE id = $id";
        $result = mysqli_query($this->db, $sql);
        $user_data = mysqli_fetch_array($result);
        echo $user_data['email'];
    }

    /*get user role */
    public function get_role($id)
    {
        $sql="SELECT role FROM users WHERE id = $id";
       
        $result = mysqli_query($this->db, $sql);
        
        $user_data = mysqli_fetch_array($result);
        // echo $user_data['role'];
        return $user_data['role'];
    }
    /*display user role */
    public function display_role($id)
    {
        $sql="SELECT role FROM users WHERE id = $id";
        $result = mysqli_query($this->db, $sql);
        $user_data = mysqli_fetch_array($result);
        echo $user_data['role'];
        return $user_data['role'];
    }
    /*change user profile */
    public function changeProfile($id)
    {
        if (isset($_POST['SubmitProfile'])) {
            $userid=$id;
            $fullname =$_POST['newfullname'];
            $email =$_POST['newemail'];
            $sql="UPDATE USERS set fullname='$fullname', email='$email' WHERE id='$id'";
            $result=mysqli_query($this->db, $sql);
            if ($result === true) {
                $message = "Updated user profile successfully!";
                echo "<script type='text/javascript'>alert('$message'); javascript:history.go(-1);</script>";
            } else {
                echo "Error updating record: " . $this->db->error;
            }
        }
    }
    /*change user password */
    public function changePwd($id)
    {
        if (isset($_POST['SubmitPwd'])) {
            $userid=$id;
            $oldpass=$_POST['currentpassword'];
            $newpassword=$_POST['password'];
            //echo $oldpass;
            //echo $newpassword;
            $sql=mysqli_query($this->db, "SELECT password FROM USERS where password='$oldpass' && id='$userid'");
            $num=mysqli_fetch_array($sql);
            if ($num>0) {//if query executed has returned with row results
                $newsql="UPDATE USERS set password='$newpassword' where id='$userid'";
                $result=mysqli_query($this->db, $newsql);
                $message = "User password has been updated successfully!";
                echo "<script type='text/javascript'>alert('$message'); javascript:history.go(-1);</script>"; //echo success message and redirect to previous page
            } else {// if user input password does not match password in db record
                $message = "Old password does not match current database record!";
                echo "<script type='text/javascript'>alert('$message'); javascript:history.go(-1);</script>"; //echo error message and redirect to previous page
            }
        }
    }

    public function resetPwd()
    {
        if (isset($_POST['resetPwd'])) {
            $email=$_POST['email'];
            $newpassword=$_POST['newpassword'];
            // echo $email;
            //echo $newpassword;
            $sql=mysqli_query($this->db, "SELECT email FROM USERS where email='$email'");
            $num=mysqli_fetch_array($sql);
            if ($num>0) {// if user email exists
                $sql2="UPDATE USERS SET password='$newpassword' where email='$email'";
            $result=mysqli_query($this->db,$sql2);
            $message = "User password has been updated successfully! Please log in with your new password!";
            echo "<script type='text/javascript'>alert('$message');window.open('login.php', '_self');</script>";
            } else {
                $message = "Such user email does not exist!";
                echo "<script type='text/javascript'>alert('$message'); javascript:history.go(-1);</script>"; //echo error message and redirect to previous page
            }
        }
    }

    /*** starting the session ***/
    public function get_session($id)
    {
        return $_SESSION['login'];
    }
    /*logging user out and destroying the session */
    public function user_logout()
    {
        $_SESSION['login'] = false;
        session_destroy();
    }
}
