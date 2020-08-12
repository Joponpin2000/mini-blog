<?php
session_start();

// include function file
require_once('../functions/DatabaseClass.php');
require_once('../functions/functions.php');


$db_connect = new DatabaseClass("localhost", "blog", "root", "");

if(!isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] !== true))
{
	header("location:adminlogin.php");
}

$name = $description = "";
$msg = "";

if (isset($_GET['id']) && (trim($_GET['id']) != ''))
{
    $id = trim($_GET['id']);

    // Populate data from database
    $sql = "SELECT * FROM topics WHERE id = :id ";
    $stmt = $db_connect->Read($sql, ["id" => $id]);

    if ($stmt)
    {
        $name = $stmt[0]['name'];
        $description = $stmt[0]['description'];
    }
    else
    {
        header("location: categories.php");
        die();            
    }

    // Close statement
    unset($stmt);
}


if(isset($_POST['submit']))
{
    $name = trim($_POST['name']);
    $slug = slug($name);
    $description = trim($_POST['description']);

    if (empty($slug))
    {
        $msg = "Please provide another category name!";
    }

    if ($msg == "")
    {
        if (isset($_GET['id']) && (trim($_GET['id']) != ''))
        {
            $id = trim($_GET['id']);
                // Execute an update statement
                $sql = "UPDATE topics SET name = :name, description = :description, slug = :slug WHERE id = :id ";
                $stmt = $db_connect->Update($sql, ['name' => $name, 'description' => $description, 'slug' => $slug, 'id' => $id]);

                // Close statement
                unset($stmt);
        }
        else
        {            
            // Execute an insert statement
            $sql = "INSERT INTO topics (name, description slug) VALUES (:name, :description :slug)";
            $stmt = $db_connect->Insert($sql, ['name' => $name, 'description' => $description, 'slug' => $slug]);

            // Close statement
            unset($stmt);
        }
        header("location: categories.php");
        die();
    }     
}

unset($pdo);

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
                            <a href="./">Dashboard</a>
                        </li>
                        <li>
                            <a href="categories.php" class="active">Categories</a>
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
                <div id="content" style="padding-left: 20px; width: 100%">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <div class="container-fluid">
                            <button class="btn" type="button" id="sidebarCollapse" style="background: #7386D5;">&#9776;</button>
                        </div>
                    </nav>
                    <div class="container">
                    <div class="title">
                        <h5>Add Category</h5>
                    </div>

                        <div class="col-sm-12 col-md-12 col-lg-12 cat-block">
                            <div class="form-block">
                            <form method="post" enctype="multipart/form-data">
                                <span class="help-block" style="color:red;"><?php echo $msg; ?></span>
                                <div class="form-group">
                                    <label for="name" class="form-control-label">Category</label>
                                    <input type="text" name="name" class="form-control" value="<?php echo $name ?>" placeholder="Enter category name" required/>
                                </div>
                                <div class="form-group">
                                    <label for="description" class="form-control-label">Description</label>
                                    <input type="text" name="description" class="form-control" value="<?php echo $description ?>" placeholder="Enter category description" required/>
                                </div>
                                <button type="submit" name="submit" class="btn btn-warning btn-block">Submit</button>
                            </form>
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

            <script>
                CKEDITOR.replace('body');
            </script>

            <script src="custom.js"></script>
            <script src="../js/main.js"></script>
    </body>
</html>