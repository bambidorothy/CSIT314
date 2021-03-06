<?php
include 'db_config.php'; //import db_config.php
include_once 'classes/user.class.php'; //import /classes/user.class.php
require_once 'classes/moderator.class.php'; //import /classes/moderator.class.php
session_start();
$user = new User();
$moderator = new Moderator();
$id = $_SESSION['id']; //store session id into $id
if (!$user->get_session($id)) { //if user is not logged in
 header("location:login.php"); //redirect to login.php *this also disables access to index.php from browser url*
}

if ($user->get_role($id) !== "moderator") {
    header("location:error.php");
}

if (isset($_GET['q'])) { //get q variable to logout
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
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script>
    // Javascript to enable link to tab
    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
    }

    // Change hash for page-reload
    $('.nav-tabs a').on('shown.bs.tab', function(e) {
        window.location.hash = e.target.hash;
    })
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
                    <a class="nav-link" href="moderator.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item mx-3">
                    <a class="nav-link">Welcome, <?php $user->get_fullname($id); ?>!</a>
                    <!--display's user fullname-->
                </li>
            </ul>
            <ul class="navbar-nav">
                <form class="form-inline my-2 my-lg-0 ml-auto">
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-white btn-md my-2 my-sm-0 ml-3" type="submit">Search</button>
                </form>
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-light" href="moderator.php?q=logout">Log Out</a>
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
                        <a class="nav-item nav-link active" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                            role="tab" aria-controls="nav-profile" aria-selected="true">Profile</a>
                        <a class="nav-item nav-link" id="topQuestion-tab" data-toggle="tab" href="#topQuestion"
                            role="tab" aria-controls="topQuestion" aria-selected="false">Most
                            Interesting Questions</a>
                        <a class="nav-item nav-link" id="topWeeklyQ-tab" data-toggle="tab" href="#topWeeklyQ" role="tab"
                            aria-controls="topWeeklyQ" aria-selected="false">Most Weekly Interesting
                            Questions</a>
                        <a class="nav-item nav-link" id="topMontlyQ-tab" data-toggle="tab" href="#topMontlyQ" role="tab"
                            aria-controls="topMontlyQ" aria-selected="false">Most Interesting Monthly
                            Questions</a>
                        <a class="nav-item nav-link" id="topStudent-tab" data-toggle="tab" href="#topStudent" role="tab"
                            aria-controls="topStudent" aria-selected="false">Top Participating Students</a>
                    </div>
                </nav>
                <!--start of tab div contents-->
                <div class="tab-content" id="nav-tabContent">
                    <!--start of profile tab-->
                    <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
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
                            <button type="submit" name="SubmitProfile" class="btn btn-danger">Update Profile
                                Details</button>
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
                    <div class="tab-pane fade" id="topQuestion" role="tabpanel" aria-labelledby="topQuestion-tab">
                    <table class="table table-responsive">
                        <tr>
                            <th>ID</th>
                            <th>Top Question</th>
                            <th>Upvote</th>
                            <th>User ID</th>
                            
                        </tr>
                        <?php $moderator->generateTopQns();?>
                        </table>
                        <br>
                        <a <?php $moderator->generateTopQuestionsFile();?> href="topQuestions.txt" download class="btn btn-danger">Generate this report</a>

                    </div>
                    <div class="tab-pane fade" id="topWeeklyQ" role="tabpanel" aria-labelledby="topWeeklyQ-tab">
                    <table class="table table-responsive">
                        <tr>
                            <th>ID</th>
                            <th>Questions</th>
                            <th>Upvote</th>
                            <th>Date</th>
                            <th>Time</th>
                        </tr>
                        <?php $moderator->generateTopWkQns();?>
                        </table>
                        <br>
                        <a <?php $moderator->generateTopWkQnsFile();?> href="topweeklyquestions.txt" download class="btn btn-danger">Generate this report</a>
                    </div>
                    <div class="tab-pane fade" id="topMontlyQ" role="tabpanel" aria-labelledby="topMontlyQ-tab">
                    <table class="table table-responsive">
                        <tr>
                            <th>ID</th>
                            <th>Questions</th>
                            <th>Upvote</th>
                            <th>Date</th>
                            <th>Time</th>
                        </tr>
                        <?php $moderator->generateTopMthQns();?>
                        </table>
                        <br>
                        <a <?php $moderator->generateTopMthQnsFile();?> href="topmonthlyquestions.txt" download class="btn btn-danger">Generate this report</a>
                    </div>
                    <div class="tab-pane fade" id="topStudent" role="tabpanel" aria-labelledby="topStudent-tab">
                        <table class="table table-responsive">
                        <tr>
                            <th>Full Name</th>
                            <th>Participation Rating</th>
                            <th>Role</th>
                        </tr>
                        <?php $moderator->generateTopStudents();?>
                        </table>
                        <br>
                        <a <?php $moderator->generateTopStudentsFile();?> href="topstudents.txt" download class="btn btn-danger">Generate this report</a>
                    </div>
                    
                </div>
            </div>
            <!--end of col-->
        </div>
        <!--end of row-->
    </div>
    <!--end of container-->
    <!--validatePassword() script-->
    <script>
    function validatePassword() {
        currentpassword,
        password,
        confirmpassword,
        output = true;

        currentpassword = document.changePwd.currentpassword;
        password = document.changePwd.password;
        confirmpassword = document.changePwd.confirmpassword;

        if (!currentpassword.value) {
            alert("Please enter your current password");
            currentpassword.focus();
            output = false;
        } else if (!password.value) {
            alert("Please enter your new password");
            password.focus();
            output = false;
        } else if (!confirmpassword.value) {
            alert("Please confirm your new password");
            confirmpassword.focus();
            output = false;
        }
        if (password.value != confirmpassword.value) {
            password.value = "";
            confirmpassword.value = "";
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
    $('.nav-tabs a').on('shown.bs.tab', function(e) {
        window.location.hash = e.target.hash;
    })
    </script>
    <!--         <footer class="fixed-bottom">
            <div class="copyright">
                &copy 2020 -Team Bambi
            </div> -->
    </footer>
</body>

</html>