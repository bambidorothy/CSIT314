<?php

class UserAccount {
    //properties
    public $fname; //public enables properties access to all classes and outside
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

class StudentAccount extends UserAccount {
        
}
?>