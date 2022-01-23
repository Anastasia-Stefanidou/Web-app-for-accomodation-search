<?php

require __DIR__.'/../boot/boot.php';

use Hotel\Room;

$room = new Room();

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

// $userId = User::getCurrentUserId();
// var_dump($userId);

// Check if room is favorite for current user
// $isFavorite = $favorite->isFavorite($roomId, $userId);


// $checkInDate = $_REQUEST['check_in_date'];
// $checkOutDate = $_REQUEST['check_out_date'];
// $alreadyBooked = empty($checkInDate) || empty($checkOutDate);

// if (!$alreadyBooked) {
//   $booking = new Booking();
//   $alreadyBooked = $booking->isBooked($roomId, $checkInDate, $checkOutDate);
//   var_dump($alreadyBooked);die;
// }

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
  <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.13.0/css/all.css"
      integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V"
      crossorigin="anonymous"
    />
  <title>Room Page</title>
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
          <form name="favoriteForm" method="post" id="favoriteForm" class="favoriteForm" action="actions/favorite.php">
              <input type="hidden" name="room_id" value="<?php echo $roomId; ?>">
              <input type="hidden" name="is_favorite" value="<?php echo $isFavorite ? '1' : '0'; ?>">
              <ul class="fav">
                  <li class="fav selected <?php echo $isFavorite ? 'selected' : ''; ?>" id="fav">❤</li>
              </ul>
          </form>
          <h2>Per Night: <?php echo $roomInfo['price'] ?>&euro;</h2>
      </div>
      <div class="room_info">
          <img src="/../extra/images/<?php echo $roomInfo['photo_url']; ?>" alt="room-2" width="100%" height="auto">
          <div class="amenities">
            <p>
              <br><i class="fas fa-user-alt"> </i> <?php echo $roomInfo['count_of_guests'] ?></br>
              COUNT OF GUESTS</p>
            <p>
              <br><i class="fas fa-bed"></i> <?php echo $roomInfo['room_id'] ?></br>
              TYPE OF ROOM</p>
            <p>
              <br><i class="fas fa-parking"></i> <?php echo $roomInfo['parking'] ?></br>
              PARKING</p>
            <p>
              <br><i class="fas fa-wifi"></i> <?php echo $roomInfo['wifi'] ?></br>
              WIFI</p>
            <p>
              <br><i class="fas fa-paw"></i> <?php echo $roomInfo['pet_friendly'] ?></br>
              PET FRIENDLY</p>
          </div>
          <h4>Room Description</h4>
          <p><?php echo $roomInfo['description_long'] ?></p>
          <div class="btn">
            <button class="btn1">Book now</button>
            <button class="btn2">Already Booked</button>
          </div>
      </div>
      <div class="map">
        <iframe src="https://maps.google.com/maps?q=<?php echo $roomInfo['location_lat'] ?>, <?php echo $roomInfo['location_long'] ?>&output=embed" width="750" height="400" frameborder="0" style="border:0"></iframe>
      </div>   
  </main>
  <footer class="margin-top">
      <p> &copy; ΔΙΠΑΕ 2021</p>
  </footer>
<script src="js_files/responsive_navbar.js"></script>
</body>
