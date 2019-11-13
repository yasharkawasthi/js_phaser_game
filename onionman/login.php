<?php
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
{
    header("location: home.php");
    exit;
}
require_once "config.php";
$gamingname = $password = "";
$gamingname_err = $password_err = "";
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(empty(trim($_POST["gamingname"])))
    {
        $gamingname_err = "Please enter Gaming Name.";
    }
    else
    {
        $gamingname = trim($_POST["gamingname"]);
    }
    if(empty(trim($_POST["password"])))
    {
        $password_err = "Please enter your Password.";
    }
    else
    {
        $password = trim($_POST["password"]);
    }
    if(empty($gamingname_err) && empty($password_err))
    {
        $sql = "SELECT id, gamingname,password FROM gamers WHERE gamingname = ?";
        if($stmt = mysqli_prepare($link, $sql))
        {
            mysqli_stmt_bind_param($stmt, "s", $param_gamingname);
            $param_gamingname = $gamingname;
            if(mysqli_stmt_execute($stmt))
            {
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {                    
                    mysqli_stmt_bind_result($stmt, $id, $gamingname, $hashed_password);
                    if(mysqli_stmt_fetch($stmt))
                    {
                        if(password_verify($password, $hashed_password))
                        {
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["gamingname"] = $gamingname;                            
                            header("location: home.php");
                        }
                        else
                        {
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                }
                else
                {
                    $gamingname_err = "No account found with that Gaming Name.";
                }
            }
            else
            {
                echo "Oops! Something went wrong. Please try again later.";
            }
        } 
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="assets/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($gamingname_err)) ? 'has-error' : ''; ?>">
                <label>Gaming Name</label>
                <input type="text" name="gamingname" class="form-control" value="<?php echo $gamingname; ?>">
                <span class="help-block"><?php echo $gamingname_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Register now</a>.</p>
        </form>
    </div>    
</body>
</html>