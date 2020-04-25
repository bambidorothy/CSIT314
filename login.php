<?php
include 'db_config.php'; //import db_config.php
include_once 'classes/user.class.php'; //import /classes/user.class.php
session_start();
$user = new User(); //create a User object (instantiation)
if (isset($_REQUEST['submit'])) {//get form values on form submission
    extract($_REQUEST);
    $login = $user->validate_login($email, $password); //runs validate_login function from /classes/user.class.php
    if ($login) {//if login is valid
        // Login Success
       header("location:index.php"); //redirect to index.php on successful login
    } else {
        // Login Failed
        echo 'Wrong username or password'; //echo failed login
    }
}
?>
<script type="text/javascript" language="javascript">

            function submitlogin() {
                var form = document.login;
				if(form.email.value == ""){
					alert( "Enter email or username." );
					return false;
				}
				else if(form.password.value == ""){
					alert( "Enter password." );
					return false;
				}
			}

</script>
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
        <title>Log In Page</title>
</head>

<body>
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
                <li class="nav-item">
                    <a class="nav-link" href="#">Link here</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <form class="form-inline my-2 my-lg-0 ml-auto">
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-white btn-md my-2 my-sm-0 ml-3" type="submit">Search</button>
                </form>
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-light" href="login.php">Log In</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-light ml-3" href="register.php">Sign Up</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <form action="" method="post" name="login">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" name="email" class="form-control" id="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password">
                    </div>
                    <button onclick="return(submitlogin());" type="submit" name="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <!--link main.js-->
    <script src="main.js"></script>
    <footer class="fixed-bottom">
        <div class="copyright">
            &copy 2020 -Team Radivz
        </div>
    </footer>
</body>

</html>