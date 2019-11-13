<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
    header("location: login.php");
    exit;
}
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thank You</title>
    <link rel="stylesheet" href="assets/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <script type="text/javascript">
    score=parseInt(getCookie("score"));
    high=parseInt(getCookie("high"));
    document.write("Your Game Score is "+score+".");
    document.write("Highest Score is "+high+".");
    function getCookie(cname)
    {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i < ca.length; i++)
        {
            var c = ca[i];
            while (c.charAt(0) == ' ')
            {
            c = c.substring(1);
            }
            if (c.indexOf(name) == 0)
            {
            return c.substring(name.length, c.length);
            }
        }
        return "";
    }
    </script>
    <div class="page-header">
        <h1>Thank You for playing this game.</h1>
        <img src="assets/bye.png" alt="onionman">
    </div>
    <p>
        <a href="osne.php" class="btn btn-success">Start Game Again</a>
        <a href="home.php" class="btn btn-warning">Home Screen</a>
        <a href="logout.php" class="btn btn-danger">Log Out</a>
    </p>
</body>
</html>