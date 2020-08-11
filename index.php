<?php
error_reporting(0);
require_once("functions/DatabaseClass.php");

$database = new DatabaseClass();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Mini Blog</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,700|Playfair+Display:400,700,900" rel="stylesheet">

    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
  
  <div class="site-wrap">

    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>
    
    <header class="site-navbar" role="banner">
      <div class="container-fluid">
        <div class="row align-items-center">
          
          <div class="col-12 search-form-wrap js-search-form" style="height: auto; margin-top: 30px;">
            <form method="get" action="">
              <input type="text" id="search-input" class="form-control" placeholder="Search...">
              <div id="result" style="position:relative;top:300; right:500;z-index: 3000;width:350px;background:white;"></div>
              <button class="search-btn" type="submit"><span class="icon-search"></span></button>
            </form>
          </div>
          <div class="col-4 site-logo">
            <a href="" class="text-black h2 mb-0">Mini Blog</a>
          </div>
          <div class="col-8 text-right">
            <nav class="site-navigation" role="navigation">
              <ul class="site-menu js-clone-nav mr-auto d-none d-lg-block mb-0">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="admin/posts.php">Login</a></li>
                <li class="d-none d-lg-inline-block"><a href="#" class="js-search-toggle"><span class="icon-search"></span></a></li>
              </ul>
            </nav>
            <a href="#" class="site-menu-toggle js-menu-toggle text-black d-inline-block d-lg-none"><span class="icon-menu h3"></span></a></div>
          </div>
      </div>
    </header>
    
    <div class="site-section bg-light">
      <div class="container">
        <div class="row align-items-stretch retro-layout-2">
          <?php
            $statement = "SELECT c.name as category_name, p.id, p.title, p.slug, p.body, p.image, p.category_id, p.created_at
            FROM posts p LEFT JOIN topics c ON p.category_id = c.id
            ORDER BY p.created_at LIMIT 0, 6";

            $posts = $database->Read($statement);

            foreach ($posts as $post)
            {
          ?>
              <div class="col-md-4">
                <a href="single.php?title=<?php echo $post['slug']?>" class="h-entry mb-30 v-height gradient" style="background-image: url('images/<?php echo $post['image']; ?>');">
                  <div class="text">
                    <h2><?php echo $post['title']; ?>
                    </h2>
                    <span class="date"><?php echo date("F j, Y ", strtotime($post['created_at'])); ?></span>
                  </div>
                </a>
              </div>
        <?php
                unset($statement);
              }
          ?>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-12">
            <h2>Recent Posts</h2>
          </div>
        </div>
        <div class="row">
            <?php
              $limit = 3;

              if (isset($_GET['page']))
              {
                $page = trim($_GET['page']);
              }
              else
              {
                $page = 1;
              }
              $start_from = ($page-1) * $limit;
              $statement = "SELECT c.name as category_name, p.id, p.title, p.slug, p.body, p.image, p.category_id, p.created_at
                              FROM posts p LEFT JOIN topics c ON p.category_id = c.id
                              ORDER BY p.created_at DESC LIMIT $start_from, $limit";

              $posts = $database->Read($statement);

              foreach ($posts as $post)
              {
            ?>
                    <div class="col-lg-4 mb-4">
                        <div class="entry2">
                        <a href="single.php?title=<?php echo $post['slug']?>"><img src="images/<?php echo $post['image']; ?>" alt="Image" class="img-fluid rounded m-i-h"></a>
                        <div class="excerpt">
                        <span class="post-category text-white bg-success mb-3"><?php echo $post['category_name']; ?></span>

                        <h2><a href="single.php?title=<?php echo $post['slug']?>"><?php echo $post['title']; ?></a></h2>
                        <div class="post-meta align-items-center text-left clearfix">
                            <figure class="author-figure mb-0 mr-3 float-left"><img src="images/person_1.jpg" alt="Image" class="img-fluid"></figure>
                            <span class="d-inline-block mt-1">By <a href="#">Carrol Atkinson</a></span>
                            <span>&nbsp;-&nbsp; <?php echo date("F j, Y ", strtotime($post['created_at'])); ?></span>
                        </div>
                        <p>
                            <?php
                                $body_limit = 50;
                                if (strlen($post['body']) <= $body_limit)
                                {
                                    echo $post['body'];
                                }
                                else
                                {
                                    echo substr_replace($post['body'], "..", $body_limit);
                                }
                            ?>
</p>
                        <p><a href="single.php?title=<?php echo $post['slug']?>">Read More</a></p>
                        </div>
                        </div>
                    </div>
          <?php
                    unset($statement);
                }
            ?>
        </div>
        <div class="row text-center pt-5 border-top">
          <div class="col-md-12">
            <div class="custom-pagination">
              <?php
                $result_db = "SELECT COUNT(id) FROM posts";
                $row_db = $database->Read($result_db);
                $total_records = $row_db[0]['COUNT(id)'];
                $total_pages = ceil($total_records / $limit);
                $pagLink = "";
                for ($i = 1; $i <= $total_pages; $i++)
                {
                  $pagLink .= "<a href='index.php?page=" . $i . "'>" . $i . "</a>";
                }
                echo $pagLink;
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section bg-light">
      <div class="container">
        <div class="row align-items-stretch retro-layout">
          <?php
              $statement = "SELECT c.name as category_name, p.id, p.title, p.slug, p.body, p.image, p.category_id, p.created_at
                              FROM posts p LEFT JOIN topics c ON p.category_id = c.id LIMIT 0, 4";
              $posts = $database->Read($statement);
              
              foreach ($posts as $post)
              {
          ?>
                <div class="col-md-6">
                  <a href="single.php?title=<?php echo $post['slug']?>" class="hentry img-2 v-height mb30 gradient" style="background-image: url('images/<?php echo $post['image']; ?>');">
                    <span class="post-category text-white bg-success"><?php echo $post['category_name']; ?></span>
                    <div class="text text-sm">
                      <h2><?php echo $post['title']; ?></h2>
                      <span><?php echo date("F j, Y ", strtotime($post['created_at'])); ?></span>
                    </div>
                  </a>
                </div>
            <?php
                    unset($statement);
                }
            ?>
        </div>
      </div>
    </div>



    <div class="site-section bg-lightx">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-md-5">
            <div class="subscribe-1 ">
              <h2>Subscribe to our newsletter</h2>
              <p class="mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sit nesciunt error illum a explicabo, ipsam nostrum.</p>
              <form action="#" class="d-flex">
                <input type="email" class="form-control" placeholder="Enter your email address" required />
                <input type="submit" class="btn btn-primary" value="Subscribe">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    
    <?php
    include_once("footer.html");
    ?>
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.countdown.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/bootstrap-datepicker.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>


  </body>
</html>