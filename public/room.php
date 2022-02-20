<?php

require __DIR__.'/../boot/boot.php';

use Hotel\Room;
use Hotel\User;
use Hotel\Booking;
use Hotel\Favorite;
use Hotel\Review;

$room = new Room();
$favorite = new Favorite();

// $review = new Review();

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
// print_r($userId);die;
// var_dump($userId);

$isFavorite = $favorite->isFavorite($roomId, $userId);
// var_dump($isFavorite);die;
// $isFavorite = true;

$review = new Review();
$allReviews = $review->getReviewsByRoom($roomId);

$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];
$alreadyBooked = empty($checkInDate) || empty($checkOutnDate);
// $alreadyBooked = true;

if (!$alreadyBooked) {
  $booking = new Booking();
  $isBooked = $booking->isBooked($roomId, $checkInDate, $checkOutDate);
}

?>
<!DOCTYPE>
<html>
</html>
<head>
  <meta name="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex,nofollow">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="css_files/room_page.css" type="text/css" rel="stylesheet" />
  <link rel="stylesheet" href="css_files/basic_styles.css">
  <script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.13.0/css/all.css"
      integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V"
      crossorigin="anonymous"
    />
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com" />
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin /> -->
    <link
			rel="stylesheet"
			href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css"
		/>
		<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
		<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script src="js_files/room.js"></script>
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
      <form action="actions/favorite.php" name="favoriteForm" method="post" id="favoriteForm" class="favoriteForm">
          <input type="hidden" name="room_id" value="<?php echo $roomId; ?>">
          <input type="hidden" name="is_favorite" value="<?php echo $isFavorite ? '1' : '0'; ?>">
          <ul class="fav">
              <li class="fav fa fa-heart <?php echo $isFavorite ? 'selected' : ''; ?>" id="fav" onclick="document.forms['favoriteForm'].submit();"></li>        
          </ul>
      </form>
    </div>
      <div class="room_info">
          <img src="/../extra/images/<?php echo $roomInfo['photo_url']; ?>" alt="room-2" width="700px" height="500px">
        </div>
          <div class="amenities">
            <p>
              <br><i class="fas fa-user-alt"> </i> <?php echo $roomInfo['count_of_guests'] ?></br>
              COUNT OF GUESTS</p>
            <p>
              <br><i class="fas fa-bed"></i> <?php echo $roomInfo['type_id'] ?></br>
              TYPE OF ROOM</p>
            <p>
              <br><i class="fas fa-parking"></i> <?php echo $roomInfo['parking'] == 1 ? 'Yes' : 'No' ?></br>
              PARKING</p>
            <p>
              <br><i class="fas fa-wifi"></i> <?php echo $roomInfo['wifi'] == 1 ? 'Yes' : 'No' ?></br>
              WIFI</p>
            <p>
              <br><i class="fas fa-paw"></i> <?php echo $roomInfo['pet_friendly'] == 1 ? 'Yes' : 'No' ?></br>
              PET FRIENDLY</p>
          </div>
          <h4>Room Description</h4>
          <p><?php echo $roomInfo['description_long'] ?></p>
          <div class="btn">
            <?php
              if ($alreadyBooked) {
            ?>
            <span class="btn2"><a href = "index.php">Already Booked!Try something else</a></span>
            <?php
              } else {
            ?>
            <form name = "bookingForm" method = "post" action = "actions/book.php">
              <input type="hidden" name = "room_id" value = "<?php echo $roomId ?>">
              <input type="hidden" name = "check_in_date" value = "<?php echo $checkInDate ?>">
              <input type="hidden" name = "check_out_date" value = "<?php echo $checkOutDate ?>">
              <button type ="submit" class="btn1">Book now</button>
            </form>
            <?php
              }
            ?>
          </div>
      </div>
      <div class="map">
        <iframe src="https://maps.google.com/maps?q=<?php echo $roomInfo['location_lat'] ?>, <?php echo $roomInfo['location_long'] ?>&output=embed" width="750" height="400" frameborder="0" style="border:0"></iframe>
      </div>
      <div class="reviews">
        <h1>Reviews</h1>
        <div id="room-reviews-container">
        <?php
          foreach ($allReviews as $review) {
        ?>
        <div class= "room_reviews">
          <div class="content_left">
            <span><?php echo $review['user_name']; ?></span>
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
      <!-- <div class="insert_review">
          <form class= "reviewForm" name="reviewForm" method="post" action ="actions/review.php">
              <input type = "hidden" value = "<?php echo $roomId?>" >
              <p>Add new Review!</p>
              <div class="stars">
              <input type = "radio" id = "5" value = "5" name = "rate" class= "fa fa-star">
              <input type = "radio" id = "4" value = "4" name = "rate" class= "fa fa-star">
              <input type = "radio" id = "3" value = "3" name = "rate" class= "fa fa-star">
              <input type = "radio" id = "2" value = "2" name = "rate" class= "fa fa-star">
              <input type = "radio" id = "1" value = "1" name = "rate" class= "fa fa-star">
              </div>
              <textarea name= "comment" id= "comment" placeholder = "Review" ></textarea>
              <button type = "submit" id= "review" >Submit</button>
          </form>
      </div> -->
  </main>
  <footer class="margin-top">
      <p> &copy; ΔΙΠΑΕ 2021</p>
  </footer>
<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<!-- <script src="js_files/fav.js"></script> -->
<script src="js_files/rating_system.js"></script>
<script src="js_files/responsive_navbar.js"></script>
</body>
