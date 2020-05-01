<?php
include("db_connection.php");

$id = $_GET['id'];

mysqli_query($conn,"DELETE FROM users WHERE id='$id'");
mysqli_close($conn);

//$message = "Deleted Successfully";
//echo "<script type='text/javascript'>alert('$message');</script>";

header("Location: userAdmin.php");
?>