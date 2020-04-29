<?php
include 'db_config.php'; //import db_config.php
include_once 'classes/user.class.php'; //import /classes/user.class.php
session_start();
$user = new User(); 
$id = $_SESSION['id']; //store session id into $id
if (!$user->get_session($id)){ //if user is not logged in
 header("location:login.php"); //redirect to login.php *this also disables access to index.php from browser url*
}

if (isset($_GET['q'])){ //get q variable to logout
 $user->user_logout(); //log user out with session destroy
 header("location:login.php");//redirect to login.php after logout
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
                <form class="form-inline my-2 my-lg-0 ml-auto">
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-white btn-md my-2 my-sm-0 ml-3" type="submit">Search</button>
                </form>
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-light" href="index.php?q=logout">Log Out</a>
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
                <a class="nav-item nav-link active" id="nav-manage-tab" data-toggle="tab" href="#nav-manage" role="tab" aria-controls="nav-manage" aria-selected="true">Manage Users</a>
                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</a>
                <a class="nav-item nav-link" id="nav-create-tab" data-toggle="tab" href="#nav-create" role="tab" aria-controls="nav-create" aria-selected="false">Create Users</a>
            </div>
            </nav>
<!--start of tab div contents-->          
<div class="tab-content" id="nav-tabContent">
<!--start of users manage tab--> 
  <div class="tab-pane fade show active" id="nav-manage" role="tabpanel" aria-labelledby="nav-manage-tab">
    <table style="width:100%">
        <tr>
            <th>Fullname</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
        <?php $user->getAccount(); ?>
    </table>
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
                        <input type="email" class="form-control" disabled id="role" value="<?php $user->get_role($id); ?>">
                    </div>
        </form>
        <form id="changePwd" action="">
        <legend>Update my Password</legend>
        <div class="form-group">
                        <label for="currentpassword">Current Password</label>
                        <input type="currentpassword" class="form-control"  id="currentpassword" >
            </div>
            <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" class="form-control"  id="password" >
            </div>
            <div class="form-group">
                        <label for="confirmpassword">Confirm Password</label>
                        <input type="confirmpassword" class="form-control"  id="confirmpassword" >
            </div>
            <button type="submit" class="btn btn-danger">Update Password</button>
        </form>
  </div>
  <!--start of create user tab--> 
  <div class="tab-pane fade" id="nav-create" role="tabpanel" aria-labelledby="nav-create-tab">
    <form id="registerUser" action="">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" >
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password">
                    </div>
                    <div class="form-group">
                        <label for="userRole">Example select</label>
                        <select class="form-control" id="userRole">
                            <option>Student</option>
                            <option>Moderator</option>
                            <option>User Administrator</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create User</button>
        </form>
  </div>
</div>
            </div>
        </div>
    </div>
    <!--end of container-->
    <!--link main.js-->
    <script src="main.js"></script>
    <footer class="fixed-bottom">
        <div class="copyright">
            &copy 2020 -Team Bambi
        </div>
    </footer>
</body>

</html>some edit