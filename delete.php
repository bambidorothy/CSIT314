<?php
include("db_connection.php");

$id = $_GET['id'];

mysqli_query($conn,"DELETE FROM users WHERE id='$id'");
mysqli_close($conn);
header("Location: userAdmin.php");
?>