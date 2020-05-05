<?php
class Post {
    private $db;
    public function __construct() //create db constructor
    {
        $this->db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        if (mysqli_connect_errno()) { //if fail to connect to database echo error
            echo "Error: Could not connect to database.";
            exit;
        }
    }
 //create answer for post
 //cast upvotes for question
}
?>