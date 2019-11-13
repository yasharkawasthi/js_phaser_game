<?php
require_once "config.php";
$gamingname = $password = $confirm_password = "";
$gamingname_err = $password_err = $confirm_password_err = "";
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(empty(trim($_POST["gamingname"])))
    {
        $gamingname_err = "Please enter a Gaming Name.";
    }
    else
    {
        $sql = "SELECT id FROM gamers WHERE gamingname = ?";
        if($stmt = mysqli_prepare($link, $sql))
        {
            mysqli_stmt_bind_param($stmt, "s", $param_gamingname);
            $param_gamingname = trim($_POST["gamingname"]);
            if(mysqli_stmt_execute($stmt))
            {
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $gamingname_err = "This Gaming Name is already taken.";
                }
                else
                {
                    $gamingname = trim($_POST["gamingname"]);
                }
            }
            else
            {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
    }
    if(empty(trim($_POST["password"])))
    {
        $password_err = "Please enter a password.";     
    }
    elseif(strlen(trim($_POST["password"])) < 6)
    {
        $password_err = "Password must have atleast 6 characters.";
    }
    else
    {
        $password = trim($_POST["password"]);
    }
    
    if(empty(trim($_POST["confirm_password"])))
    {
        $confirm_password_err = "Please confirm password.";     
    }
    else
    {
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password))
        {
            $confirm_password_err = "Password did not match.";
        }
    }
    if(empty($gamingname_err) && empty($password_err) && empty($confirm_password_err))
    {
        
        $sql = "INSERT INTO gamers (gamingname, password) VALUES (?, ?)";
        if($stmt = mysqli_prepare($link, $sql))
        {
            mysqli_stmt_bind_param($stmt, "ss", $param_gamingname, $param_password);
            $param_gamingname = $gamingname;
            $param_password = password_hash($password, PASSWORD_DEFAULT); 
            if(mysqli_stmt_execute($stmt))
            {
                header("location: login.php");
            }
            else
            {
                echo "Something went wrong. Please try again later.";
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="assets/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Register</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($gamingname_err)) ? 'has-error' : ''; ?>">
                <label>Gaming Name</label>
                <input type="text" name="gamingname" class="form-control" value="<?php echo $gamingname; ?>">
                <span class="help-block"><?php echo $gamingname_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>