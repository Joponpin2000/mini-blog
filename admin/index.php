<?php
session_start();

// include function file
require_once('../functions/DatabaseClass.php');

$db_connect = new DatabaseClass("localhost", "blog", "root", "");

if(!isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] !== true))
{
	header("location:adminlogin.php");
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

        <script src="../js/jquery-3.3.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>

  </head>
  <body>

            <div class="wrapper">
                <nav id="sidebar">
                    <div class="sidebar-header">
                        <h3 style="color: white">Admin Panel</h3>
                    </div>
                    <ul class="list-unstyled components">
                        <li>
                            <a href="./" class="active">Dashboard</a>
                        </li>
                        <li>
                            <a href="categories.php">Categories</a>
                        </li>
                        <li>
                            <a href="posts.php">Posts</a>
                        </li>
                        <li>
                            <a href="contact_us.php">Contact Us</a>
                        </li>
                        <li>
                            <a href="about.php">About Us</a>
                        </li>
                        <li>
                            <a href="logout.php">Logout</a>
                        </li>
                    </ul>
                </nav>
                <div id="content" style="padding-left: 20px; width: 100vw">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <div class="container-fluid">
                            <button class="btn" type="button" id="sidebarCollapse" style="background: #7386D5;">&#9776;</button>
                        </div>
                    </nav>
                    <div class="title">
                        <h3>Dashboard</h3>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6 col-md-4 col-lg-4">
                                <a href="categories.php">
                                    <div class="service-card btn" style="background: inherit;">
                                    <div class="caption">
                                        <h4>Categories</h4>
                                        <p>Manage Categories</p>
                                    </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-4">
                                <a href="posts.php">
                                    <div class="service-card btn" style="background: inherit;">
                                    <div class="caption">
                                        <h4>Posts</h4>
                                        <p>Manage Posts</p>
                                    </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-4">
                                <a href="contact_us.php">
                                    <div class="service-card btn" style="background: inherit;">
                                    <div class="caption">
                                        <h4>Contacts</h4>
                                        <p>Manage Contacts</p>
                                    </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-4">
                                <a href="about.php">
                                    <div class="service-card btn" style="background: inherit;">
                                    <div class="caption">
                                        <h4>About</h4>
                                        <p>Manage About</p>
                                    </div>
                                    </div>
                                </a>
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
                </div>
                
            </div>

            <script src="custom.js"></script>
            <script src="../js/main.js"></script>
    </body>
</html>