<?php
session_start();

// include function file
require_once('../functions/DatabaseClass.php');

$db_connect = new DatabaseClass("localhost", "blog", "root", "");

if(!isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] !== true))
{
	header("location:adminlogin.php");
}

if (isset($_GET['type']) && trim($_GET['type']) != '')
{
    $type = trim($_GET['type']);

    if ($type == 'delete')
    {
        $id = trim($_GET['id']);
        
        // Execute a Delete statement
        $sql = "DELETE FROM posts WHERE id = :id";
        $stmt = $db_connect->Remove($sql, ['id' => $id]);

        // Close statement
        unset($stmt);
    }
}

// Populate data from database
$sql = "SELECT posts.*, topics.name FROM posts, topics WHERE posts.category_id=topics.id ORDER BY posts.id DESC";
$result = $db_connect->Read($sql);
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
                            <a href="categories.php">Categories</a>
                        </li>
                        <li>
                            <a href="posts.php" class="active">Posts</a>
                        </li>
                        <li>
                            <a href="contact_us.php">Contact Us</a>
                        </li>
                        <li>
                            <a href="about.php" class="active">About Us</a>
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
                        <h3>Posts</h3>
                        <h5><a href="manage_posts.php" style="text-decoration: underline; color: #7386D5;">Add Post</a></h5>
                    </div>
                    <?php
                        if ($result)
                        {
                    ?>
                            <div class="table" style="width: 100%;">
                                <table style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ID</th>
                                            <th>Category</th>
                                            <th>Post Title</th>
                                            <th>Body</th>
                                            <th>Image</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $i = 1;
                                            foreach ($result as $row)
                                            {
                                        ?>
                                                <tr>
                                                    <td><?php echo $i ?></td>
                                                    <td><?php echo $row['id'] ?></td>
                                                    <td><?php echo $row['name'] ?></td>
                                                    <td><?php echo $row['title'] ?></td>
                                                    <td><?php echo substr_replace($row['body'], "...", 100); ?></td>
                                                    <td><img src="<?php echo "../images/" . $row['image']?>" style="width: 40px; height: 30px"/></td>
                                                    <td style="text-align: right;">
                                                        <?php
                                                        echo "<span class='sett edit'><a href='manage_posts.php?id=" . $row['id'] .  "'>Edit</a></span>";

                                                        echo "&nbsp;<span class='sett delete'><a href='?type=delete&id=" . $row['id'] .  "'>Delete</a><span>";
                                                        ?>
                                                    </td>
                                                </tr>
                                        <?php
                                            ++$i;
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                    <?php 
                        }
                        else
                        {
                    ?>
                            <h5 style="color: red;">No posts yet!</h5>
                    <?php
                        }
                    ?>

                    <div class="copyrights">
                        <div class="container">
                            <div class="row">
                            <div style="text-align: center; width: 100%;">
                                <p>All Rights Reserved. &copy; 2020 <b><a href="#">MINI BLOG</a></b> Developed by : <a href="jofedo.netlify.app"><b>Idowu Joseph</b></a></p>
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