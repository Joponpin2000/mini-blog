<?php
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
          
          <div class="col-12 search-form-wrap js-search-form">
            <form method="get" action="#">
              <input type="text" id="s" class="form-control" placeholder="Search...">
              <button class="search-btn" type="submit"><span class="icon-search"></span></button>
            </form>
          </div>

          <div class="col-4 site-logo">
            <a href="index.html" class="text-black h2 mb-0">Mini Blog</a>
          </div>

          <div class="col-8 text-right">
            <nav class="site-navigation" role="navigation">
              <ul class="site-menu js-clone-nav mr-auto d-none d-lg-block mb-0">
                <li><a href="">Home</a></li>
                <li><a href="">Politics</a></li>
                <li><a href="">Tech</a></li>
                <li><a href="">Entertainment</a></li>
                <li><a href="">Travel</a></li>
                <li><a href="">Sports</a></li>
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
              ORDER BY p.created_at";

              $posts = $database->Read($statement);

              foreach ($posts as $post)
              {
          ?>
          <div class="col-md-4">
            <a href="single_post.php?title=<?php echo $post['slug']?>" class="h-entry mb-30 v-height gradient" style="background-image: url('images/<?php echo $post['image']; ?>');">
              
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
                $statement = "SELECT c.name as category_name, p.id, p.title, p.slug, p.body, p.image, p.category_id, p.created_at
                                FROM posts p LEFT JOIN topics c ON p.category_id = c.id
                                ORDER BY p.created_at DESC";

                $posts = $database->Read($statement);

                foreach ($posts as $post)
                {
            ?>
                    <div class="col-lg-4 mb-4">
                        <div class="entry2">
                        <a href="single.html"><img src="images/<?php echo $post['image']; ?>" alt="Image" class="img-fluid rounded"></a>
                        <div class="excerpt">
                        <span class="post-category text-white bg-success mb-3"><?php echo $post['category_name']; ?></span>

                        <h2><a href="single.html"><?php echo $post['title']; ?></a></h2>
                        <div class="post-meta align-items-center text-left clearfix">
                            <figure class="author-figure mb-0 mr-3 float-left"><img src="images/person_1.jpg" alt="Image" class="img-fluid"></figure>
                            <span class="d-inline-block mt-1">By <a href="#">Carrol Atkinson</a></span>
                            <span>&nbsp;-&nbsp; <?php echo date("F j, Y ", strtotime($post['created_at'])); ?></span>
                        </div>
                        <p>
                            <?php
                                $limit = 50;
                                if (strlen($post['title']) <= $limit)
                                {
                                    echo $post['body'];
                                }
                                else
                                {
                                    echo substr_replace($post['body'], "..", $limit);
                                }
                            ?>
</p>
                        <p><a href="#">Read More</a></p>
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
              <span>1</span>
              <a href="#">2</a>
              <a href="#">3</a>
              <a href="#">4</a>
              <span>...</span>
              <a href="#">15</a>
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
                              FROM posts p LEFT JOIN topics c ON p.category_id = c.id";
              $posts = $database->Read($statement);
              
              foreach ($posts as $post)
              {
          ?>
                <div class="col-md-6">
                  <a href="single.html" class="hentry img-2 v-height mb30 gradient" style="background-image: url('images/<?php echo $post['image']; ?>');">
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
    
    
    <div class="site-footer">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-4">
            <h3 class="footer-heading mb-4">About Us</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat reprehenderit magnam deleniti quasi saepe, consequatur atque sequi delectus dolore veritatis obcaecati quae, repellat eveniet omnis, voluptatem in. Soluta, eligendi, architecto.</p>
          </div>
          <div class="col-md-3 ml-auto">
            <!-- <h3 class="footer-heading mb-4">Navigation</h3> -->
            <ul class="list-unstyled float-left mr-5">
              <li><a href="#">About Us</a></li>
              <li><a href="#">Advertise</a></li>
              <li><a href="#">Careers</a></li>
              <li><a href="#">Subscribes</a></li>
            </ul>
            <ul class="list-unstyled float-left">
              <li><a href="#">Travel</a></li>
              <li><a href="#">Lifestyle</a></li>
              <li><a href="#">Sports</a></li>
              <li><a href="#">Nature</a></li>
            </ul>
          </div>
          <div class="col-md-4">
            

            <div>
              <h3 class="footer-heading mb-4">Connect With Us</h3>
              <p>
                <a href="#"><span class="icon-facebook pt-2 pr-2 pb-2 pl-0"></span></a>
                <a href="#"><span class="icon-twitter p-2"></span></a>
                <a href="#"><span class="icon-instagram p-2"></span></a>
                <a href="#"><span class="icon-rss p-2"></span></a>
                <a href="#"><span class="icon-envelope p-2"></span></a>
              </p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 text-center">
            <p>
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              Copyright &copy; <script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart text-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" >Colorlib</a>
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              </p>
          </div>
        </div>
      </div>
    </div>
    
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