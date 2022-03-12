<?php

require __DIR__.'/../boot/boot.php';

use Hotel\Room;
use Hotel\User;
use Hotel\Booking;
use Hotel\Favorite;
use Hotel\Review;

$room = new Room();
$favorite = new Favorite();
$review = new Review();

// Check for room id
$roomId = $_REQUEST['room_id'];
if (empty($roomId)) {
  header('Location: index.php');
  return;
}

$roomInfo = $room->get($roomId); 
if (empty($roomInfo)) {
    header('Location: index.php');
    return;
  }

//Get current user id
$userId = User::getCurrentUserId();

$isFavorite = $favorite->isFavorite($roomId, $userId);

$allReviews = $review->getReviewsByRoom($roomId);

$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];

$booking = new Booking();
$datesMissing = empty($checkInDate) || empty($checkOutDate);
$alreadyBooked = $booking->isBooked($roomId, $checkInDate, $checkOutDate);
if (!$alreadyBooked) {
  $booking = new Booking();
  $moreInfo = $booking->getInfo($roomId);
  $alreadyBooked = $booking->isBooked($roomId, $checkInDate, $checkOutDate);
}

$roomTitle = $roomInfo['type_id'];

if ($roomTitle == 1) {
  $roomTitle = 'Single Room';
}elseif ($roomTitle == 2) {
  $roomTitle = 'Double Room';
} elseif ($roomTitle == 3) {
  $roomTitle = 'Triple Room';
} {
  $roomTitle = 'Fourfold Room';
}

?>
<!DOCTYPE>
<html>
  <head>
    <meta name="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="starrr.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js_files/starrr.js"></script>
    <link href="css_files/room_page.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="css_files/basic_styles.css" />
    <!-- <link rel="stylesheet" href= "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V" crossorigin="anonymous" /> -->
    <script src="js_files/popup.js"></script>
    <title><?php echo $roomInfo['name'] ;?></title>
  </head>
  <body>
    <header>
      <nav class="navbar">
          <ul>
              <li class="navbar-logo">TravelBug</li>
              <li class="navbar-toggle"><i class="fas fa-bars"></i></li>
              <li class="navbar-links"><a href="index.php">Home</a></li>
              <li class="navbar-links"><a href="profile.php" target="_blank">Profile</a></li>
              <li class="navbar-links"><a href="register.php">Register</a></li>
              <li class="navbar-links"><a href="login.php">Log in</a></li>
          </ul>
      </nav>
    </header>
    <main class="container">
      <div class= "top_header">
        <div class="title">
            <h1><?php echo sprintf('%s - %s, %s', $roomInfo['name'], $roomInfo['city'], $roomInfo['area']) ?></h1>
            <h2>Reviews</h2>
            <?php
              $roomAvgReview = $roomInfo['avg_reviews']; 
                for ($i=1; $i <=5; $i++) {
                  if ($roomAvgReview >= $i) {
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
            <h2>Per Night: <?php echo $roomInfo['price'] ?>&euro;</h2>
        </div>
      </div>
        <div class="room_info">
          <div class="first_box">
            <img src="/../extra/images/<?php echo $roomInfo['photo_url']; ?>" alt="room-2" width="700px" height="500px">
            <div class="description">
              <div class="room_title">
                <h4>Room Description</h4>
                <form action="actions/favorite.php" name="favoriteForm" method="post" id="favoriteForm" class="favoriteForm">
                <input type="hidden" name="room_id" value="<?php echo $roomId; ?>">
                <input type="hidden" name="is_favorite" value="<?php echo $isFavorite ? '1' : '0'; ?>">
                <ul class="fav">
                    <li class="fav fa fa-heart <?php echo $isFavorite ? 'selected' : ''; ?>" id="fav" onclick="document.forms['favoriteForm'].submit();"></li>    
                </ul>
                </form>
              </div>
              <div class= "popup">
                <i class="fas fa-map"></i> <h1 button id="myBtn">Excellent location - Show map</h1>
                <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <iframe src="https://maps.google.com/maps?q=<?php echo $roomInfo['location_lat'] ?>, <?php echo $roomInfo['location_long'] ?>&output=embed" frameborder="0" style="border:0"></iframe>
                </div>
                </div>
              </div>
              <p><?php echo $roomInfo['description_long'] ?></p>
              <div class="amenities">
                <p><i class="fas fa-user-alt"></i> COUNT OF GUESTS: </p><p><?php echo $roomInfo['count_of_guests'] ?></p>
                <p><i class="fas fa-bed"></i> TYPE OF ROOM: </p><p><?php echo $roomTitle ?></p>
                <p><i class="fas fa-parking"></i> PARKING: </p><p><?php echo $roomInfo['parking'] == 1 ? 'Yes' : 'No' ?></p>
                <p><i class="fas fa-wifi"></i> WIFI: </p><p><?php echo $roomInfo['wifi'] == 1 ? 'Yes' : 'No' ?></p>
                <p><i class="fas fa-paw"></i> PET FRIENDLY: </p><p><?php echo $roomInfo['pet_friendly'] == 1 ? 'Yes' : 'No' ?></p>
              </div>
                <?php
                  if ($datesMissing) {
                ?>
                  <span class="btn1"><a class= "check_availability" href = "list.php">Please fill both dates to check availability.</a></span>
                <?php
                  } elseif ($alreadyBooked) {
                ?>
                  <span class="btn2"><a href = "index.php">Already Booked!Try something else</a></span>
                <?php
                  } else {
                ?>
                <?php
                  if (!$userId) {
                ?>
                  <form name = "bookingForm" method="post" action="actions/book.php">
                    <input type="hidden" name = "room_id" value="<?php echo $roomId ?>">
                    <input type="hidden" name = "check_in_date" value="<?php echo $checkInDate ?>">
                    <input type="hidden" name = "check_out_date" value="<?php echo $checkOutDate ?>">
                    <button type ="submit" class="btn3">Book now</button>
                  </form>
                <?php
                  } else {
                ?>
                <span class="btn2">Log in first</span>
                <?php
                  }
                ?>
                <?php
                  }
                ?>
              </div>
            </div>
          </div>
          </div>
          <div class= "all_reviews">
            <div class="show_reviews">
              
            </div>
          </div>             
        <?php
            if(count($allReviews) > 0) {
        ?>
          <div class="reviews">
            <h1>Reviews</h1>
            <div id="room-reviews-container">
            <?php
              foreach ($allReviews as $counter => $review) {
            ?>
            <div class= "room_reviews">
              <div class="content_left">
                <span><?php echo sprintf ('%d. %s', $counter + 1, $review['user_name']); ?></span>
              </div>
              <div class="content_right">
                <h5><?php echo $review['created_time']; ?></h5>
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
              <p><?php echo htmlentities ($review['comment']); ?></p>
              </div>
            </div>
            <?php
              }
            ?>
            </div>
          </div>
        <?php
            } else {
        ?>
        <div class = "no_reviews">
          <p>There are no reviews yet.</p>
        <?php
            }
        ?>
        </div>
        <!-- <div class="insert_review">
            <form class= "reviewForm" name="reviewForm" method="post" action ="actions/review.php">
                <input type="hidden" name="room_id" value="<?php echo $roomId ?>">
                <p>Add new Review!</p>
                <input type="hidden" id="rate" name="rating" value="<?php echo $iRate ?>">
                <p>Based on: <span><?php echo $roomInfo['count_reviews'] ?></span> rating</p>
                <textarea name= "comment" id= "comment" placeholder = "Review" ></textarea>
                <button type = "submit" id= "review" onsubmit="return showRating(this);">Submit</button>
            </form>
        </div> -->
        <div>
        </div>
        <form method="POST" onsubmit="return saveRatings(this);">
        <input type="hidden" name="room_id" value="<?php echo $roomId ?>">
        <input type="hidden" name="user_id" value="<?php echo $userId ?>">
        <textarea name= "comment" id= "comment" placeholder = "Review" value="<?php echo $comment ?>"></textarea>
            <p>
                <div class="starrr"></div>
            </p>
            <input type="submit">
      </form>
      <div class="rate"></div>
      <script>
        var rate = 0;
        $(function () {
            $(".starrr").starrr().on("starrr:change", function (event, value) {
                rate = value;
            });
        });

        function saveRatings(form) {
            var room_id = form.room_id.value;
            var comment = form.comment.value;
            var user_id = form.user_id.value;

            $.ajax({
                url: "ajax/save-ratings.php",
                method: "POST",
                data: {
                    "room_id": room_id,
                    "rate": rate,
                    "comment": comment,
                    "user_id": user_id
                },
                success: function (response) {
                    alert(response);
                }
            });
            return false;
        }
    </script>
    </main>
    <footer class="margin-top">
        <p> &copy; ΔΙΠΑΕ 2021</p>
    </footer>
  <script src="js_files/responsive_navbar.js"></script> -->
  </body>
</html>



