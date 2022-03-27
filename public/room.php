<?php

require __DIR__.'/../boot/boot.php';

use Hotel\Room;
use Hotel\User;
use Hotel\Booking;
use Hotel\Favorite;
use Hotel\Review;
// use Hotel\Payment;

$room = new Room();
$favorite = new Favorite();
$review = new Review();
// $payment = new Payment();

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

// Get current user id
$userId = User::getCurrentUserId();

$isFavorite = $favorite->isFavorite($roomId, $userId);

$allReviews = $review->getReviewsByRoom($roomId);
$averageReview = $review->averageReview($roomId);

$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];

$booking = new Booking();
$datesMissing = empty($checkInDate) || empty($checkOutDate);
$alreadyBooked = $booking->isBooked($roomId, $checkInDate, $checkOutDate);
if (!$alreadyBooked) {
  $booking = new Booking();
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

$totalPrice = $booking->bookingDetails($roomId, $userId, $checkInDate, $checkOutDate);
//Get all bookings for current user
$userInfo = $booking->UserBookingInfo($roomId, $userId);
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
    <title><?php echo $roomInfo['name'] ;?> | TravelBug</title>
  </head>
  <body>
    <header>
      <nav class="navbar">
          <ul>
              <li class="navbar-logo"><a href="index.php">TravelBug</a></li>
              <li class="navbar-toggle"><i class="fa fa-bars"></i></li>
              <li class="navbar-links"><a href="index.php">Home</a></li>
              <li class="navbar-links"><a href="profile.php" target="_blank">Profile</a></li>
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
    <main class="container">
      <div class= "top_header">
        <div class="title">
            <h1><?php echo sprintf('%s - %s, %s', $roomInfo['name'], $roomInfo['city'], $roomInfo['area']) ?></h1>
            <form action="actions/favorite.php" name="favoriteForm" method="post" id="favoriteForm" class="favoriteForm">
                <input type="hidden" name="room_id" value="<?php echo $roomId; ?>">
                <input type="hidden" name="is_favorite" value="<?php echo $isFavorite ? '1' : '0'; ?>">
                <ul class="fav">
                    <li class="fav fa fa-heart <?php echo $isFavorite ? 'selected' : ''; ?>" id="fav" onclick="document.forms['favoriteForm'].submit();"></li>    
                </ul>
                </form>
            <h2>Per Night: <?php echo $roomInfo['price'] ?>&euro;</h2>
        </div>
      </div>
        <div class="room_info">
          <div class="first_box">
            <div class="image_gallery">
              <div id="selected_img">
                  <img src="/../extra/images/<?php echo $roomInfo['photo_url']; ?>" alt="<?php echo $roomInfo['name'] ;?>">
              </div>
              <ul id="image_list">
                  <li><img src="/../extra/images/<?php echo $roomInfo['photo_url1']; ?>" alt="<?php echo $roomInfo['name'] ;?>"></li>
                  <li><img src="/../extra/images/<?php echo $roomInfo['photo_url2']; ?>" alt="<?php echo $roomInfo['name'] ;?>"></li>
                  <li><img src="/../extra/images/<?php echo $roomInfo['photo_url3']; ?>" alt="<?php echo $roomInfo['name'] ;?>"></li>
                  <li><img src="/../extra/images/<?php echo $roomInfo['photo_url4']; ?>" alt="<?php echo $roomInfo['name'] ;?>"></li>
                  <li><img src="/../extra/images/<?php echo $roomInfo['photo_url5']; ?>" alt="<?php echo $roomInfo['name'] ;?>"></li>
              </ul>
          </div>  
            <div class="description">
              <div class="room_title">
              </div>
              <div class= "popup">
                <i class="fa fa-map-marker"></i> <h1 button id="myBtn">Excellent location - Show map</h1>
                <div id="myModal" class="modal">
                  <div class="modal-content">
                      <p class="close">&times;</p>
                      <iframe src="https://maps.google.com/maps?q=<?php echo $roomInfo['location_lat'] ?>, <?php echo $roomInfo['location_long'] ?>&output=embed" frameborder="0" style="border:0"></iframe>
                  </div>
              </div>
              </div>
              <p><?php echo $roomInfo['description_long'] ?></p>
              <div class="amenities">
                <p><i class="fa fa-user"></i> COUNT OF GUESTS: </p><p><?php echo $roomInfo['count_of_guests'] ?></p>
                <p><i class="fa fa-building"></i> TYPE OF ROOM: </p><p><?php echo $roomTitle ?></p>
                <p><i class="fa fa-car"></i> PARKING: </p><p><?php echo $roomInfo['parking'] == 1 ? 'Yes' : 'No' ?></p>
                <p><i class="fa fa-wifi"></i> WIFI: </p><p><?php echo $roomInfo['wifi'] == 1 ? 'Yes' : 'No' ?></p>
                <p><i class="fa fa-paw"></i> PET FRIENDLY: </p><p><?php echo $roomInfo['pet_friendly'] == 1 ? 'Yes' : 'No' ?></p>
              </div>
              </div>
            </div>
          </div>
          </div>
          <div class="second_container">
            <div class="firstItem">
              <?php
              if ($datesMissing) {
                ?>
                  <span class="btn1"><a class= "check_availability" href = "list.php">Check availability</a></span>
                <?php
                  } elseif ($alreadyBooked) {
                ?>
                  <span class="btn2">Already Booked</span>
                <?php
                  } else {
                ?>
                <?php
                  if ($userId || !$alreadyBooked) {
                ?>
                  <div class="booking_details">
                    <h1>Your booking details...</h1>
                    <div class="dates">
                      <p class="details">Check-in<br><?php echo $checkInDate ?></br></p>
                      <p>Check-out<br><?php echo $checkOutDate ?></br></p>
                    </div>
                    <div class="pay">
                      <p class="price"><br>Total Price</br><?php echo $totalPrice ?> €</p>
                      <button name="submitForm" type ="submit" class="btn3"><a href="book.php?room_id=<?php echo $roomId; ?>&check_in_date=<?php echo $checkInDate; ?>&check_out_date=<?php echo $checkOutDate; ?>" target="_blank">Book now</a></button>
                      <!-- <form class="bookingForm" name = "bookingForm" method="post" action="actions/book.php" onSubmit="alert('Your booking confirmed!');">
                        <input type="hidden" name = "room_id" value="<?php echo $roomId ?>">
                        <input type="hidden" name = "check_in_date" value="<?php echo $checkInDate ?>">
                        <input type="hidden" name = "check_out_date" value="<?php echo $checkOutDate ?>">
                        <button name="submitForm" type ="submit" class="btn3">Book now</button>
                    </form> -->
                    </div>
                  </div>
                <?php
                  } else {
                ?>
                <span class="btn2"><a href = "login.php">Log in first</a></span>
                <?php
                  }
                ?>
                <?php
                  }
                ?>  
            </div>         
            <div class="reviews">
              <div class="review_title">
              <?php
                if ($userInfo > 0) {
              ?>
                <div class= "popup">
                  <button id="myBtn1"><i class="fa fa-pencil"></i>POST REVIEW</button>
                  <div id="myModal1" class="modal">
                    <div class="modal-content1">
                      <span class="close1">&times;</span>
                      <?php
                        if ($userId) {
                      ?>
                        <div class="insertReview">
                        <h1>Your review</h1>
                        <form method="POST" class="reviewForm" onsubmit="return saveRatings(this);">
                          <input type="hidden" name="room_id" value="<?php echo $roomId ?>">
                          <input type="hidden" name="user_id" value="<?php echo $userId ?>">
                          <p><div class="starrr"></div></p>
                          <textarea name= "comment" id= "comment" placeholder = "Your review..." value="<?php echo $comment ?>"></textarea>
                          <input type="submit" id="review">
                        </form>
                        <div class="rate"></div>
                        </div>
                        <?php
                          } else {
                        ?>
                          <p><a href="login.php">Log in first</a></p>
                        <?php
                          }
                        ?>
                    </div>
                  </div>
                </div>
                <?php
                }
                ?>
                <?php
                if ($roomInfo['avg_reviews']) {
              ?>
                <div class="average_reviews">
                  <h1><?php echo $roomInfo['avg_reviews']; ?></h1>
                    <div class="stars">
                      <?php
                      $roomAvgReview = $roomInfo['avg_reviews'];
                        for ($i=1; $i <= 5; $i++) {
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
                    </div>
                    <p><span><?php echo $roomInfo['count_reviews'] ?></span> reviews</p> 
                  </div>
              </div>
                  <div class="reviews">
                    <?php
                      foreach ($allReviews as $counter => $review) {
                    ?>
                      <div class="content_left">
                        <span><?php echo sprintf ('%d. %s', $counter + 1, $review['user_name']); ?></span>
                        <h5><?php echo $review['created_time']; ?></h5>
                      </div>
                      <div class="content_right">
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
                      <p><?php echo htmlentities ($review['comment']); ?></p>
                    <?php
                      }
                    ?>
                    </div>
                  </div>
              <?php 
                  } else { 
                ?>
                <span>This room has no reviews yet.</span>
                <?php
                    }
                ?>  
            </div>
          </div>          
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
                    // $('.modal-content1').html(response);
                }
            });
            return false;
        }
    </script>
    </main>
    <footer class="margin-top">
        <p> &copy; ΔΙΠΑΕ 2021</p>
    </footer>
  <script src="js_files/responsive_navbar.js"></script>
  </body>
</html>



