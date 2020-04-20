<?php

class UserAccount {
    //properties
    public $fname;
    public $userid;
    public $pwd;
    public $role;

    //methods
    public function setProperties($fname,$userid,$pwd,$role) {
        $this->fname = $fname; //set name
        $this->userid = $userid; //set userid
        $this->pwd = $pwd; //set password
        $this->role = $role; //set role
    }
}
?>