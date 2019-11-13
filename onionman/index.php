<?php
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
{
    header("location: home.php");
    exit;
}
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OnionMan</title>
    <link rel="stylesheet" href="assets/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
        <img src="assets/wall.png" alt="onionman">
        <br><br>
    <p>
        <a href="login.php" class="btn btn-primary">Login</a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="register.php" class="btn btn-primary">Register</a>
    </p>
</body>
</html>