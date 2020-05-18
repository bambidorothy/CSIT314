<?php
include 'db_config.php'; //import db_config.php
include_once 'classes/user.class.php';
include_once 'classes/useradmin.class.php'; //import /classes/user.class.php

session_start();
$user = new User(); 
$useradmin = new useradmin();
$id = $_SESSION['id']; //store session id into $id
if (!$user->get_session($id)){ //if user is not logged in
 header("location:login.php"); //redirect to login.php *this also disables access to index.php from browser url*
}

if ($user->get_role($id) !== "useradmin") {
    header("location:error.php");
    }
if (isset($_GET['q'])){ //get q variable to logout
 $user->user_logout(); //log user out with session destroy
 header("location:login.php");//redirect to login.php after logout
 }

//=================================================================
  

if (isset($_POST['registerbtn'])){
    $registerfullname;
    $registerusername;
    $registeremail;
    $registerpassword;
    $registerrole;
    require 'db_connection.php';


    $registerfullname = mysqli_real_escape_string($conn,$_POST['registerfullname']);
    $registerusername= mysqli_real_escape_string($conn,$_POST['registerusername']);
    $registeremail = mysqli_real_escape_string($conn,$_POST['registeremail']);
    $registerpassword= mysqli_real_escape_string($conn,$_POST['registerpassword']);
    $registerrole = mysqli_real_escape_string($conn,$_POST['registerrole']);
    
    

    $created = $useradmin->createUser($registerfullname,$registerusername,$registeremail,$registerpassword,$registerrole);



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
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
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
                    <a class="nav-link" href="userAdmin.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item mx-3">
                    <a class="nav-link">Welcome, <?php $user->get_fullname($id); ?>!</a>
                    <!--display's user fullname-->
                </li>
            </ul>
            <ul class="navbar-nav">
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
                        <a class="nav-item nav-link active" id="nav-manage-tab" data-toggle="tab" href="#nav-manage"
                            role="tab" aria-controls="nav-manage" aria-selected="true">Manage Users</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                            role="tab" aria-controls="nav-profile" aria-selected="false">Profile</a>
                        <a class="nav-item nav-link" id="nav-create-tab" data-toggle="tab" href="#nav-create" role="tab"
                            aria-controls="nav-create" aria-selected="false">Create Users</a>
                        <a class="nav-item nav-link" id="nav-suspend-tab" data-toggle="tab" href="#nav-suspend"
                            role="tab" aria-controls="nav-suspend" aria-selected="false">Suspend/Restore Users</a>
                    </div>
                </nav>
                <!--start of tab div contents-->
                <div class="tab-content" id="nav-tabContent">
                    <!--start of users manage tab-->
                    <div class="tab-pane fade show active" id="nav-manage" role="tabpanel"
                        aria-labelledby="nav-manage-tab">
                        <table style="width:100%">
                            <tr>
                                <th>ID</th>
                                <th>Fullname</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                            <?php 
        include("db_connection.php");
        $sql=("SELECT id, fullname, username, email, role, status from users");
        $result = mysqli_query($conn, $sql);
        if ($result-> num_rows > 0) {
            while ($row = $result-> fetch_assoc()) { 
        ?>
                            <tr>
                                <td><?php echo $row['id'];?></td>
                                <td><?php echo $row['fullname'];?></td>
                                <td><?php echo $row['username'];?></td>
                                <td><?php echo $row['email'];?></td>
                                <td><?php echo $row['role'];?></td>
                                <td><?php echo $row['status'];?></td>
                                <td><a href="delete.php?id=<?php echo $row['id'];?>"><button type="submit"
                                            name="deletesubmit" style="margin- 
        left:250px;" class="btn btn-primary">Delete</button></a></td>
                            </tr>
                            <?php 
}
echo "</table>";
}
else {
echo "0 result"; 
}
?>
                        </table>
                    </div>

                    <!--start of profile tab-->
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <form id="" action="">
                            <div class="form-group">
                                <label for="email">Full Name</label>
                                <input type="text" class="form-control" disabled id="fullname"
                                    value="<?php $user->get_fullname($id); ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" disabled id="email"
                                    value="<?php $user->get_email($id); ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Account Role</label>
                                <input type="email" class="form-control" disabled id="role"
                                    value="<?php $user->display_role($id); ?>">
                            </div>
                        </form>
                        <!--START OF UPDATE PROFILE FORM-->
                        <form id="changeProfile" action="changeProfile.php" method="post">
                            <legend>Update my Profile</legend>
                            <div class="form-group">
                                <label for="newfullname">New Full Name</label>
                                <input type="text" required class="form-control" name="newfullname" id="newfullname">
                            </div>
                            <div class="form-group">
                                <label for="newemail">New Email</label>
                                <input type="email" required class="form-control" name="newemail" id="newemail">
                            </div>
                            <button type="submit" name="SubmitProfile" class="btn btn-danger">Update Profile Details</button>
                        </form>
                        <hr>
                        <!--START OF CHANGE PASSWORD FORM-->
                        <form id="changePwd" name="changePwd" onSubmit="return validatePassword()" method="post"
                            action="changePwd.php">
                            <legend>Update my Password</legend>
                            <div class="form-group">
                                <label for="currentpassword">Current Password</label>
                                <input type="password" name="currentpassword" class="form-control" id="currentpassword">
                            </div>
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" name="password" class="form-control" id="password">
                            </div>
                            <div class="form-group">
                                <label for="confirmpassword">Confirm Password</label>
                                <input type="password" name="confirmpassword" class="form-control" id="confirmpassword">
                            </div>
                            <button type="submit" name="SubmitPwd" class="btn btn-danger">Update Password</button>
                        </form>
                    </div>
                    <!--start of create user tab-->
                    <div class="tab-pane fade" id="nav-create" role="tabpanel" aria-labelledby="nav-create-tab">
                        <form id="registerUser" method="post">
                            <div class="form-group">
                                <label>Full name</label>
                                <input type="text" class="form-control" name="registerfullname" required>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="registerusername" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="registeremail" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="registerpassword" required>
                            </div>
                            <div class="form-group">
                                <label for="userRole">Example select</label>
                                <select class="form-control" name="registerrole" required>
                                    <option>Select role</option>
                                    <option value="student">Student</option>
                                    <option value="moderator">Moderator</option>
                                    <option value="useradmin">User Administrator</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary" name="registerbtn">Create User</button>
                        </form>
                    </div>
                    <!--start of suspend/restore user account tab form-->
                    <div class="tab-pane fade" id="nav-suspend" role="tabpanel" aria-labelledby="nav-suspend-tab">
                        <form action="suspendUser.php" method="post">
                            <legend>
                                Suspend User Account
                            </legend>
                            <div class="form group">
                                <label for="fullname">Enter full name of user account to suspend</label>
                                <input type="text" name="fullname" class="form-control" id="fullname">
                            </div>
                            <br>
                            <button type="submit" class="btn btn-danger">Suspend User Account</button>
                        </form>

                        <form action="restoreUser.php" method="post">
                            <legend>
                                Restore User Account
                            </legend>
                            <div class="form group">
                                <label for="fullname">Enter full name of user account to restore</label>
                                <input type="text" name="fullname" class="form-control" id="fullname">
                            </div>
                            <br>
                            <button type="submit" class="btn btn-success">Restore User Account</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
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
    <!--<footer class="fixed-bottom">
        <div class="copyright">
            &copy 2020 -Team Bambi
        </div>
    </footer> -->
</body>

</html>