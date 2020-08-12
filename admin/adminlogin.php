<?php
// include function file
require_once('../functions/DatabaseClass.php');

$db_connect = new DatabaseClass("localhost", "blog", "root", "");

//Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    //Check if username is empty
    if(empty(trim($_POST["username"])))
    {
        $username_err = "Please enter username.";
    }
    else
    {
        $username = trim($_POST["username"]);
    }

    //check if password is empty
    if(empty(trim($_POST["password"])))
    {
        $password_err = "Please enter your password.";
    }
    else
    {
        $password = trim($_POST["password"]);
    }

    //validate credentials
    if(empty($username_err) && empty($password_err))
    {
        //prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = :username AND password = :password";

        $stmt = $db_connect->Read($sql, ['username' => $username, 'password' => $password]);
        if ($stmt)
        {
            session_start();
            // Store data in session
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $stmt['id'];

            // Redirect user to home page
            header("location: ./");
        }
        else
        {
            // Display an error message if username doesn't exist
            $password_err = "Invalid username / password combination.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Mini Blog</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,700|Playfair+Display:400,700,900" rel="stylesheet">

    <link rel="stylesheet" href="../fonts/icomoon/style.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/magnific-popup.css">
    <link rel="stylesheet" href="../css/jquery-ui.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/owl.theme.default.min.css">
    <link rel="stylesheet" href="../css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="../css/aos.css">

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="style.css">


  </head>
  <body>
            <div class="center-block" style="margin: 100px auto; width: 70%;">
                <div class="container">
                    <div class="row">
                            <div class="col-sm-12 col-md-6 col-md-6" style="padding: 10px;">
                                <h4><span style="color: #7386D5;">MINI BLOG</span> | Admin Login</h4>
                            </div>
                            <div class="col-sm-12 col-md-6 col-md-6" style="background-color: white; padding: 10px;">
                                <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="username" value="<?php echo $username; ?>" required/>
                                        <span class="help-block"><?php echo $username_err; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password" value="<?php echo $password; ?>" required/>
                                        <span class="help-block"><?php echo $password_err; ?></span>
                                    </div>
                                    <button type="submit" style="background-color: #7386D5; border-color: #7386D5" class="btn btn-warning btn-block">Submit</button>
                                    <a href="" class="pull-left help-block">Forgot Password?</a>
                                </form>
                            </div>
                    </div>
                </div>    
            </div>

        <div class="copyrights">
            <div class="container">
                <div class="row">
                <div style="text-align: center; width: 100%;">
                    <p>All Rights Reserved. &copy; 2020 <b><a href="../">MINI BLOG</a></b> Developed by : <a href="jofedo.netlify.app"><b>Idowu Joseph</b></a></p>
                </div>
                </div>
            </div><!-- end container -->
        </div><!-- end copyrights -->
    

        <script src="custom.js"></script>
        <script src="../js/main.js"></script>
    </body>
</html>