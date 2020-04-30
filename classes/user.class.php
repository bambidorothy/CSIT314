<?php
class User //create User class
{   
    
    

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
?>
