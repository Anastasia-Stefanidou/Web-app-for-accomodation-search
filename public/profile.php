<?php

require __DIR__.'/../boot/boot.php';

use Hotel\Favorite;
use Hotel\Review;
use Hotel\Booking;
use Hotel\User;

$userId = User::getCurrentUserId();
if (empty($userId)) {
  header('Location: index.php');
  return;
}

//Get user favorites
$favorite = new Favorite();
$userFavorites = $favorite->getByUser($userId);

//Get user reviews
$review = new Review();
$userReviews = $review->getByUser($userId);

//Get user bookings
$booking = new Booking();
$userBookings = $booking->getByUser($userId);

?>
<!DOCTYPE>
<html>
  <head>
    <meta name="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <link rel="stylesheet" href= "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css_files/basic_styles.css" />
    <link rel="stylesheet" href="css_files/profile-page.css" />
    <title>Profile | TravelBug</title>
  </head>
  <body>
    <header>
      <nav class="navbar">
          <ul>
              <li class="navbar-logo"><a href="index.php">TravelBug</a></li>
              <li class="navbar-toggle"><i class="fas fa-bars"></i></li>
              <li class="navbar-links"><a href="index.php">Home</a></li>
              <li class="navbar-links current_page"><a href="profile.php" target="_blank">Profile</a></li>
              <?php
                  if (!empty($userId)) {
              ?>
                  <li class="navbar-links"><a href='actions/logout.php'>Log out</a></li>
              <?php
                  } else {
              ?>
                  <li class="navbar-links"><a href="register.php">Register</a></li>
                  <li class="navbar-links"><a href='login.php'>Log in</a></li>
              <?php
                  }
              ?>
          </ul>
      </nav>
    </header>
    <main>  
      <div class="tabs">
        <div class="season_tabs">
        <div class="season_tab">
            <input type="radio" id="tab-1" name="tab-group-1">
            <label for="tab-1">My Reviews</label> 
            <div class="season_content">
              <div class="reviews">
                <!-- <h1>Reviews</h1> -->
                <?php
                  if (count($userReviews) > 0) {
                ?>
                  <ul>
                    <?php
                      foreach ($userReviews as $counter => $review) {
                    ?>
                    <li>
                      <h3 class="inner_container">
                        <a href="room.php?room_id=<?php echo $review['room_id']; ?>" target="_blank"><?php echo sprintf ('%d. %s', $counter + 1, $review['name']); ?></a>
                        <div class="stars">
                          <?php
                            for ($i=1; $i <=5; $i++) {
                              if ($review['rate'] >= $i) {
                          ?>
                              <span class="fa fa-star checked"></span>
                          <?php
                              } else { 
                          ?>
                              <span class="fa fa-star"></span>
                          <?php
                              }
                          }
                          ?>  
                        </div>
                        <div class= "comment">
                          <h3><?php echo $review['comment'] ?></h3>
                        </div>
                      </h3>
                    </li>
                    <?php
                      }
                    ?>
                  </ul>
                <?php 
                  } else {
                ?>
                  <h2 class="error">You don't have any reviews.</h2>
                <?php 
                  }
                ?>
              </div>
            </div> 
        </div>
        <div class="season_tab">
            <input type="radio" id="tab-2" name="tab-group-1">
            <label for="tab-2">My Favorites</label>
            <div class="season_content">
              <div class="favorites">
                <!-- <h1>Favorites</h1> -->
                <?php
                  if (count($userFavorites) > 0) {
                ?>
                  <ul class="fav">
                    <?php
                      foreach ($userFavorites as $counter => $favorite) {
                    ?>
                    <li>
                      <h3 class="user_fav">
                        <a href="room.php?room_id=<?php echo $favorite['room_id']; ?>" target="_blank"><?php echo sprintf ('%d. %s', $counter + 1, $favorite['name']); ?></a>
                      </h3>
                    </li>
                    <li>
                    </li>
                    <?php
                      }
                    ?>
                  </ul>
                <?php 
                  } else {
                ?>
                  <h2 class="error">You don't have any favorite Hotel.</h2>
                <?php 
                  }
                ?>
              </div>
            </div> 
        </div>
          <div class="season_tab">
            <input type="radio" id="tab-3" name="tab-group-1">
            <label for="tab-3">My Bookings</label> 
            <div class="season_content">
              <div class="title">
              </div>
                <?php
                  if (count($userBookings) > 0) {
                ?>
                  <ul>
                    <?php
                      foreach ($userBookings as $booking) {
                    ?>
                    <li>
                      <h3 class = "bookings">
                        <div class="img">
                          <img src="/../extra/images/<?php echo $booking['photo_url']; ?>">
                        </div>
                        <div class="right_side">
                          <div class="main">
                            <h1><?php echo $booking['name'] ?></h1>
                            <p><?php echo $booking['city'] ?> , <?php echo $booking['area'] ?></p>
                            <p><?php echo $booking['description_short'] ?></p>
                          </div>
                          <div class="extra">
                            <p class="price">Total price: <span> <?php echo $booking['total_price'] ?> €</span></p>
                            <p class="check_in_date">Check in: <span><?php echo $booking['check_in_date'] ?></span></p>
                            <p class="check_out_date">Check out: <span><?php echo $booking['check_out_date'] ?></span></p>
                            <a href="room.php?room_id=<?php echo $booking['room_id']; ?>" target="_blank">Go to room page</a>
                          </div>
                      </div>
                      </h3>
                      </li>
                      <?php
                        }
                      ?>
                    </ul>
                  <?php 
                    } else {
                  ?>
                    <h2 class="error">You don't have any bookings.</h2>
                  <?php 
                    }
                  ?>
            </div> 
        </div>   
      </div>
      </div>
    </main>
    <footer class="margin-top">
        <p> &copy; ΔΙΠΑΕ 2021</p>
    </footer>
  <script src="js_files/responsive_navbar.js"></script>
  <!-- <script src="js_files/tabs.js"></script> -->
  </body>
</html>