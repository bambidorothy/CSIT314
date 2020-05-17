<?php
//include_once 'db_config.php'; //import db_config.php
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
 date_default_timezone_set("Asia/Singapore");
 if (isset($_POST["ansPostbtn"])) {
     $answer;
     require "db_connection.php";
     $answer = mysqli_real_escape_string($conn, $_POST["ansQuestion"]);
     $postDate = date("Y-m-d");
     $postTime = date("h:i a");
     require_once "classes\student.class.php";
     $student->ansPost($id,$answer, $postDate, $postTime);
 }
 date_default_timezone_set("Asia/Singapore");
 if (isset($_POST["comPostbtn"])) {
     $comment;
     require "db_connection.php";
     $comment = mysqli_real_escape_string($conn, $_POST["comPost"]);
     $postDate = date("Y-m-d");
     $postTime = date("h:i a");
     require_once "classes\student.class.php";
     $student->commPost($id,$comment, $postDate, $postTime);
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

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <script>
    function goBack() {
        window.history.back();
    }
    </script>

    <title>View Post</title>
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
                    <a class="nav-link" href="student.php">Home <span class="sr-only">(current)</span></a>
                <li class="nav-item">
                    <a class="nav-link" onclick="goBack()">Back<i class="fas fa-arrow-left"></i></a>
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

                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#postAns"
                                    aria-expanded="true" aria-controls="postAns">
                                    List of question answers
                                </button>
                            </h2>
                        </div>

                        <div id="postAns" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                                <table class="table table-responsive">
                                    <tr>
                                        <th>id</th>
                                        <th>content</th>
                                        <th>upvote</th>
                                        <th>date</th>
                                        <th>time</th>
                                    </tr>
                                    <?php $student->getAnswer(); ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h2 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                    data-target="#postComment" aria-expanded="false" aria-controls="postComment">
                                    List of question comments
                                </button>
                            </h2>
                        </div>
                        <div id="postComment" class="collapse" aria-labelledby="headingTwo"
                            data-parent="#accordionExample">
                            <div class="card-body">

                                <table class="table table-responsive">
                                    <tr>
                                        <th>comment</th>
                                        <th>date</th>
                                        <th>time</th>
                                    </tr>
                                    <td>
                                        <h3><?php $student->getQComment(); ?></h3>
                                    </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table table-responsive">
                    <tr>
                        <th>
                            <h1>Question:</h1>
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <h3><?php $student->getContent($id); ?></h3>
                        </td>
                        <table>
                            <form id="answer" method="post">
                                <div class="form-group">
                                    <label>Answer:</label>
                                    <textarea rows="5" cols="10" type="text" class="form-control"
                                        name="ansQuestion"></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" name="ansPostbtn">Submit</button>
                                </div>

                            </form>

                            <form id="comment" method="post">
                                <div class="form-group">
                                    <label>Comment:</label>
                                    <textarea rows="5" cols="10" type="text" class="form-control"
                                        name="comPost"></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" name="comPostbtn">Submit</button>
                                </div>

                            </form>
            </div>
        </div>
    </div>
</body>