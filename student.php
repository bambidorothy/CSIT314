<?php
include 'db_config.php'; //import db_config.php
include_once 'classes/user.class.php'; //import /classes/user.class.php
include_once 'classes/student.class.php'; //import /classes/student.class.php

session_start();
$user = new User();
$student = new Student();
$id = $_SESSION['id']; //store session id into $id

if (!$user->get_session($id)) { //if user is not logged in
 header("location:login.php"); //redirect to login.php *this also disables access to index.php from browser url*
}

if ($user->get_role($id) !== "student") {
    header("location:error.php");
}

if (isset($_GET['q'])) { //get q variable to logout
 $user->user_logout(); //log user out with session destroy
 header("location:login.php");//redirect to login.php after logout
}

//create post
//=======================================================================================
date_default_timezone_set("Asia/Singapore");
if (isset($_POST["createPostbtn"])) {
    $question;
    require "db_connection.php";
    $question = mysqli_real_escape_string($conn, $_POST["postQuestion"]);
    $postDate = date("Y-m-d");
    $postTime = date("h:i a");
    require_once "classes\student.class.php";
    $student->createPost($id, $question, $postDate, $postTime);
}
//search 
//=======================================================================================
include_once 'db_connection.php';
$connect = mysqli_connect("localhost","root","","csit314");
$output ="";
if(isset($_POST["searchButton"])){
    $searchValue = $_POST["searchValue"];
    $query = "SELECT * FROM post WHERE content LIKE '%".$searchValue."%'";
    $filter_result = mysqli_query($connect, $query);
    $count = mysqli_num_rows($filter_result);
    //$serach_result = search($query);

    if ($count == 0) {
        $output = "No search result found!";
    }
    else{
        while($row = mysqli_fetch_array($filter_result)){
            $content = $row['content'];
            $output .= '<div>'  .$content. '</div>';

        }

        }
    }


?>

<!DOCTYPE html>
<html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--link to styles.css-->
    <link rel="stylesheet" href="./styles.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
    <title>Home</title>
</head>

<body>
    <!--start of navbar-->
    <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler"
            aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Topics</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Forums</a>
                </li>
                <li class="nav-item mx-3">
                <a class="nav-link">Welcome, <?php $user->get_fullname($id); ?>!</a> <!--display's user fullname-->
                </li>
            </ul>
            <ul class="navbar-nav">
               
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-light" href="student.php?q=logout">Log Out</a>
                </li>
            </ul>
        </div>
    </nav>
    <!--end of navbar-->
    <!--start of container-->
    <div class="container">
        <div class="row">
            <div class="col">
            <!--start of nav tablist-->
            <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-createpost-tab" data-toggle="tab" href="#nav-createpost" role="tab" aria-controls="nav-createpost" aria-selected="true">Create Post</a>
                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</a>
                <a class="nav-item nav-link" id="nav-manage-post" data-toggle="tab" href="#nav-managepost" role="tab" aria-controls="nav-managepost" aria-selected="false">View/Manage Posts</a>
                <a class="nav-item nav-link" id="nav-search-post" data-toggle="tab" href="#nav-searchpost" role="tab" aria-controls="nav-searchpost" aria-selected="false">Search Post</a>
            </div>
            </nav>

<!--start of tab div contents-->          
<div class="tab-content" id="nav-tabContent">
<!--start of post create tab--> 
  <div class="tab-pane fade show active" id="nav-createpost" role="tabpanel" aria-labelledby="nav-createpost-tab">
        <form id="post" method="post">
                    <div class="form-group">
                        <label >My question:</label>
                        <textarea rows="10"  cols="50" type="text" class="form-control" name="postQuestion"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="createPostbtn">Post</button>
                    </div>
                   
        </form>
  
  </div>
  <div class="tab-pane fade" id="nav-searchpost" role="tabpanel" aria-labelledby="nav-search-post">
            <form method="post">
                    <div class="form-group">
                        <label >Search question:</label>
                        <textarea rows="5"  cols="5" type="text" class="form-control" name="searchValue"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="searchButton">submit</button>
                    </div>
                    <div>
                    <?php print("$output"); ?>
                    </div>
                   
        </form>
  
        </div>
  <!--start of profile tab--> 
  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
  <form id="" action="">
                    <div class="form-group">
                        <label for="email">Full Name</label>
                        <input type="text" class="form-control" disabled id="fullname" value="<?php $user->get_fullname($id); ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" disabled id="email" value="<?php $user->get_email($id); ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Account Role</label>
                        <input type="email" class="form-control" disabled id="role" value="<?php $user->display_role($id); ?>">
                    </div>
        </form>
        <!--START OF UPDATE PROFILE FORM-->
        <form id="changeProfile" action="changeProfile.php" method="post">
        <legend>Update my Profile</legend>
        <div class="form-group">
                        <label for="newfullname">New Full Name</label>
                        <input type="text" required class="form-control" name="newfullname" id="newfullname" >
            </div>
            <div class="form-group">
                        <label for="newemail">New Email</label>
                        <input type="email" required class="form-control" name="newemail" id="newemail" >
            </div>
            <button type="submit" name="SubmitProfile" class="btn btn-danger">Update Profile Details</button>
        </form>
        <hr>
        <!--START OF CHANGE PASSWORD FORM-->
        <form id="changePwd" name="changePwd" onSubmit="return validatePassword()" method="post" action="changePwd.php">
        <legend>Update my Password</legend>
        <div class="form-group">
                        <label for="currentpassword">Current Password</label>
                        <input type="password" name="currentpassword" class="form-control"  id="currentpassword" >
            </div>
            <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" name="password" class="form-control"  id="password" >
            </div>
            <div class="form-group">
                        <label for="confirmpassword">Confirm Password</label>
                        <input type="password" name="confirmpassword" class="form-control"  id="confirmpassword" >
            </div>
            <button type="submit" name="SubmitPwd" class="btn btn-danger">Update Password</button>
        </form>
  </div>
  <!--start of manage post tab--> 
  <div class="tab-pane fade" id="nav-managepost" role="tabpanel" aria-labelledby="nav-manage-post">
  <h1>Your Posts</h1>
  <table class="table table-responsive">
  <tr>
    <th>ID</th>
    <th>Content</th>
    <th>Upvotes</th>
    <th>Date</th>
    <th>Time</th>
    <th>Status</th>
  </tr>
  <?php $student->displayPosts($id);?> <!--calls the displayPosts function in student.class.php-->
  </table>
  <hr>
  <h1>Public Posts</h1>
  <table class="table table-responsive">
  <tr>
    <th>ID</th>
    <th>Content</th>
    <th>Upvotes</th>
    <th>Date</th>
    <th>Time</th>
    <th>Status</th>
    <?php $student->displayAllPosts($id);?>
  </tr>
  </div>
</div>

                    </div>
                </div>    
            </div>
            </div> <!--end of col-->
        </div> <!--end of row-->

    </div>
   
    <!--end of container-->
    <!--validatePassword() script-->
    <script>
    function validatePassword() {
    currentpassword,password,confirmpassword,output = true;

    currentpassword = document.changePwd.currentpassword;
    password = document.changePwd.password;
    confirmpassword = document.changePwd.confirmpassword;

    if(!currentpassword.value) {
    alert("Please enter your current password");
    currentpassword.focus();
    output = false;
    }
    else if(!password.value) {
    alert("Please enter your new password");
    password.focus();
    output = false;
    }
    else if(!confirmpassword.value) {
    alert("Please confirm your new password");
    confirmpassword.focus();
    output = false;
    }
    if(password.value != confirmpassword.value) {
    password.value = "";
    confirmpassword.value="";
    alert("Field input in new password and confirm password do not match!");
    password.focus();
    output = false;
    }
    return output;
    }
</script>
<script>
        // Javascript to enable link to tab
    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
    } 

    // Change hash for page-reload
    $('.nav-tabs a').on('shown.bs.tab', function (e) {
        window.location.hash = e.target.hash;
    })
    </script>
    
    <footer class="fixed-bottom">
        <div class="copyright">
            &copy 2020 -Team Bambi
        </div>
    </footer>
</body>

</html>