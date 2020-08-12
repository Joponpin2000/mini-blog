<?php
require_once("functions/DatabaseClass.php");

$msg = "";
$name = $email = $website = $message = "";
$name_err = $email_err = $message_err = "";


if(isset($_GET['title']))
{
  $slug = trim($_GET['title']);
  $database = new DatabaseClass("localhost", "blog", "root", "");

  $sql = "SELECT c.name as category_name, c.slug as category_slug, p.id, p.title, p.slug, p.body, p.image, p.category_id, p.created_at
  FROM posts p LEFT JOIN topics c ON p.category_id = c.id
  WHERE p.slug = :slug";
  $blog = $database->Read($sql, ["slug" => $slug]);


  if ($blog)
  {
      // Populate data from the database
      $query = "SELECT c.name as category_name, p.id, p.title, p.slug, p.body, p.image, p.category_id, p.created_at
      FROM posts p LEFT JOIN topics c ON p.category_id = c.id
      ORDER BY p.created_at DESC LIMIT 0, 4";
      $posts = $database->Read($query);

      $sql = "SELECT * FROM reply WHERE post_id = :post_id ORDER BY id DESC";
      $result = $database->Read($sql, ["post_id" => $blog[0]['id']]);

      $ano_sql = "SELECT COUNT(*) FROM reply WHERE post_id = :post_id";
      $num_comment = $database->Read($ano_sql, ["post_id" => $blog[0]['id']]);

      $statement = "SELECT * FROM topics ORDER BY id DESC LIMIT 0, 6";
      $categories = $database->Read($statement);
  }
  else
  {
      header("location: index.php");
      exit;
  }
}
else
{
    header("location: index.php");
    exit;
}

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
            <a href="index.php" class="text-black h2 mb-0">Mini Blog</a>
          </div>

          <div class="col-8 text-right">
            <nav class="site-navigation" role="navigation">
              <ul class="site-menu js-clone-nav mr-auto d-none d-lg-block mb-0">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                
                <li class="d-none d-lg-inline-block"><a href="#" class="js-search-toggle"><span class="icon-search"></span></a></li>
              </ul>
            </nav>
            <a href="#" class="site-menu-toggle js-menu-toggle text-black d-inline-block d-lg-none"><span class="icon-menu h3"></span></a></div>
          </div>

      </div>
    </header>
    
    
    <div class="site-cover site-cover-sm same-height overlay single-page" style="background-image: url('images/<?php echo $blog[0]['image']; ?>');">
      <div class="container">
        <div class="row same-height justify-content-center">
          <div class="col-md-12 col-lg-10">
            <div class="post-entry text-center">
              <span class="post-category text-white bg-success mb-3"><?php echo $blog[0]['category_name']; ?></span>
              <h1 class="mb-4"><?php echo $blog[0]['title']; ?></h1>
              <div class="post-meta align-items-center text-center">
                <figure class="author-figure mb-0 mr-3 d-inline-block"><img src="images/person_1.jpg" alt="Image" class="img-fluid"></figure>
                <span class="d-inline-block mt-1">By author</span>
                <span>&nbsp;-&nbsp; <?php echo date("F j, Y ", strtotime($blog[0]['created_at'])); ?></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <section class="site-section py-lg">
      <div class="container">
        
        <div class="row blog-entries element-animate">

          <div class="col-md-12 col-lg-8 main-content">
            
            <div class="post-content-body">
              <h1><?php echo $blog[0]['title']; ?></h1>
              <?php echo $blog[0]['body']; ?>
            </div>

            
            <div class="pt-5">
              <p>Category:  <a href="category.php?title=<?php echo $blog[0]['category_slug']?>"><?php echo $blog[0]['category_name']; ?></a></p>
            </div>


            <div class="pt-5">
              <h3 class="mb-5"><?php echo $num_comment[0]['COUNT(*)']; ?> Comments</h3>
              <ul class="comment-list">
                <?php
                  foreach ($result as $reply)
                  {
                ?>
                <li class="comment">
                  <div class="vcard">
                    <img src="images/person_1.jpg" alt="Image placeholder">
                  </div>
                  <div class="comment-body">
                    <h3><?php echo $reply['name']; ?></h3>
                    <div class="meta"><?php echo date("F j, Y ", strtotime($reply['added_on'])); ?></div>
                    <p><?php echo $reply['reply']; ?></p>
                  </div>
                </li>
                <?php
                  }
                ?>
              </ul>
              <!-- END comment-list -->
              
              <div class="comment-form-wrap pt-5">
                <h3 class="mb-5">Leave a comment</h3>
                <form method="POST" action="validate_comment.php" role="form" class="p-5 bg-light">
                  <div class="form-group">
                    <label for="name">Name *</label>
                    <input class="form-control" name="name" value="<?php echo $name; ?>" type="text" required>
                    <span class="help-block"><?php echo $name_err; ?></span>
                  </div>
                  <div class="form-group">
                    <label for="email">Email *</label>
                    <input class="form-control" name="email" type="text" value="<?php echo $email; ?>" required>
                    <span class="help-block"><?php echo $email_err; ?></span>
                  </div>
                  <div class="form-group">
                    <label for="website">Website</label>
                    <input class="form-control" name="website" type="text" value="<?php echo $website; ?>">
                  </div>
                  <div class="form-group">
                      <label for="message">Message *</label>
                      <textarea class="form-control" name="message" cols="30" rows="10" value="<?php echo $message; ?>" required></textarea>
                      <span class="help-block"><?php echo $message_err; ?></span>
                  </div>
                  <div class="form-group">
                    <input type="hidden" name="post_id" value="<?php echo $blog[0]['id']; ?>">
                    <input type="submit" value="Post Comment" name="submit" class="btn btn-primary">
                  </div>
                </form>
              </div>
            </div>

          </div>

          <!-- END main-content -->

          <div class="col-md-12 col-lg-4 sidebar">
            <div class="sidebar-box search-form-wrap">
              <form action="#" class="search-form">
                <div class="form-group">
                  <span class="icon fa fa-search"></span>
                  <input type="text" class="form-control" id="s" placeholder="Type a keyword and hit enter">
                </div>
              </form>
            </div>
            <!-- END sidebar-box -->
            <div class="sidebar-box">
              <div class="bio text-center">
                <img src="images/person_1.jpg" alt="Image Placeholder" class="img-fluid mb-5">
                <div class="bio-body">
                  <h2>Mary Doe</h2>
                  <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem facilis sunt repellendus excepturi beatae porro debitis voluptate nulla quo veniam fuga sit molestias minus.</p>
                  <!--
                    <p><a href="#" class="btn btn-primary btn-sm rounded px-4 py-2">Read my bio</a></p>
                  -->
                  <p class="social">
                    <a href="#" class="p-2"><span class="fa fa-facebook"></span></a>
                    <a href="#" class="p-2"><span class="fa fa-twitter"></span></a>
                    <a href="#" class="p-2"><span class="fa fa-instagram"></span></a>
                    <a href="#" class="p-2"><span class="fa fa-youtube-play"></span></a>
                  </p>
                </div>
              </div>
            </div>
            <!-- END sidebar-box -->  
            <div class="sidebar-box">
              <h3 class="heading">Popular Posts</h3>
              <div class="post-entry-sidebar">
                <ul>
                <?php
                  foreach ($posts as $post)
                  {
                ?>
                    <li>
                      <a href="single.php?title=<?php echo $post['slug']?>">
                        <img src="images/<?php echo $post['image']; ?>" alt="Image placeholder" class="mr-4">
                        <div class="text">
                          <h4><?php echo $post['title']; ?></h4>
                          <div class="post-meta">
                            <span class="mr-2"><?php echo date("F j, Y ", strtotime($post['created_at'])); ?> </span>
                          </div>
                        </div>
                      </a>
                    </li>
                <?php
                  }
                ?>
                </ul>
              </div>
            </div>
            <!-- END sidebar-box -->

            <div class="sidebar-box">
              <h3 class="heading">Categories</h3>
              <ul class="categories">
              <?php
                foreach ($categories as $category)
                {
                  $query = "SELECT COUNT(*) FROM posts WHERE category_id=:category_id";
                  $count = $database->Read($query, ["category_id" => $category['id']]);
            ?>
                  <li><a href="category.php?title=<?php echo $category['slug']?>"><?php echo $category['name']?> <span><?php echo $count[0]['COUNT(*)']; ?></span></a></li>
              <?php
                }
              ?>
              </ul>
            </div>
            <!-- END sidebar-box -->

            <div class="sidebar-box">
              <h3 class="heading">Tags</h3>
              <ul class="tags">
                <?php
                  foreach ($categories as $category)
                  {
                ?>
                <li><a href="category.php?title=<?php echo $category['slug']?>"><?php echo $category['name']?></a></li>
                <?php
                  }
                ?>
              </ul>
            </div>
          </div>
          <!-- END sidebar -->

        </div>
      </div>
    </section>

    <div class="site-section bg-light">
      <div class="container">

        <div class="row mb-5">
          <div class="col-12">
            <h2>More Related Posts</h2>
          </div>
        </div>

        <div class="row align-items-stretch retro-layout">
          <?php
              foreach ($posts as $post)
              {
          ?>
                <div class="col-md-6">
                  <a href="single.php?title=<?php echo $post['slug']?>" class="hentry img-2 v-height mb30 gradient" style="background-image: url('images/<?php echo $post['image']; ?>');">
                    <span class="post-category text-white bg-danger"><?php echo $post['category_name']; ?></span>
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
                <input type="text" class="form-control" placeholder="Enter your email address">
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