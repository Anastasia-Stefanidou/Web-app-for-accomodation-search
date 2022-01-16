<?php

require __DIR__.'/../boot/boot.php';

header('Access-Control-Allow-Origin: *');

use Hotel\Room;
use Hotel\Favorite;
use Hotel\User;

$room = new Room();
$favorite = new Favorite();



// Check for room id
$roomId = $_REQUEST['room_id'];
if (empty($roomId)) {
  header('Location: index.php');
  return;
}

$roomInfo = $room->get($roomId);
if (empty($roomInfo)) {
    header('Location: index.php');
    die;
  }

$roomInfo = $room->get($roomId);
// print_r($roomInfo);die;

$userId = User::getCurrentUserId();
// var_dump($userId);

// Check if room is favorite for current user
$isFavorite = $favorite->isFavorite($roomId, $userId);


$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];
$alreadyBooked = empty($checkInDate) || empty($checkOutDate);

if (!$alreadyBooked) {
  $booking = new Booking();
  $alreadyBooked = $booking->isBooked($roomId, $checkInDate, $checkOutDate);
  var_dump($alreadyBooked);die;
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
<style>
.checked {
  color: orange;
}
</style>
  <title>Room-page2</title>
</head>
<body>
    <header>
      <div class="box-shadow">
          <span class="main-logo">Hotels</span>
        <div class="primary-menu text-right">
            <ul>
                  <li id="divleft">
                      <a href="profile.html" target="_blank">
                        <i class="fas fa-user"></i>
                        Profile
                    </a>
                  </li>
                  <li id="divright">
                      <a href="project.html" target="_blank">
                        <i class="fas fa-home"></i>
                        Home
                      </a>
                  </li>
            </ul>
        </div>
      </div>
    </header>
    <main>
      <div class="maincontent">
          <div class="page-title inline-block">
              <h2 class="whiteborder"><?php echo sprintf('%s - %s, %s', $roomInfo['name'], $roomInfo['city'], $roomInfo['area']) ?></h2>
              <h1 class="whiteborder">Reviews</h1>
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
                 <div class="title-reviews inline-block">
                    <form name="favoriteForm" method="post" id="favoriteForm" class="favoriteForm" action="actions/favorite.php">
                        <input type="hidden" name="room_id" value="<?php echo $roomId; ?>">
                        <input type="hidden" name="is_favorite" value="<?php echo $isFavorite ? '1' : '0'; ?>">
                        <ul class="fav_star">
                            <span class="star <?php echo $isFavorite ? 'selected' : ''; ?>" id="fav">❤</span>
                        </ul>
                    </form>
                 </div>
              <h2>Per Night: <?php echo $roomInfo['price'] ?>&euro;</h2>
          </div>
          <article class="hotel">
              <aside class="main-photo">
                  <img src="/../extra/images/<?php echo $roomInfo['photo_url']; ?> " alt="room-2" width="100%" height="auto">
              </aside>
              <div class="orange-box">
                  <p class="left-box inline-block">
                    <br><i class="fas fa-user-alt"> </i> <?php echo $roomInfo['count_of_guests'] ?></br>
                     COUNT OF GUESTS</p>
                  <p class="middle-box inline-block">
                    <br><i class="fas fa-bed"></i> <?php echo $roomInfo['room_id'] ?></br>
                    TYPE OF ROOM</p>
                  <p class="middle-box inline-block">
                    <br><i class="fas fa-parking"></i> <?php echo $roomInfo['parking'] ?></br>
                    PARKING</p>
                  <p class="middle-box inline-block">
                    <br><i class="fas fa-wifi"></i> <?php echo $roomInfo['wifi'] ?></br>
                    WIFI</p>
                  <p class="right-box inline-block">
                    <br><i class="fas fa-paw"></i> <?php echo $roomInfo['pet_friendly'] ?></br>
                    PET FRIENDLY</p>
              </div>
              <div class="description inline-block">
                <section class="borderleft">
                   <h4>Room Description</h4>
                   <p><?php echo $roomInfo['description_long'] ?></p>
                </section>
               <button class="book-now">Book now</button>
               <button class="booked">Already Booked</button>
             </div>
             <section class="map">
                <iframe src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=1%20Vasileos%20Georgiou%20A,%20Syntagma%20Square%20Str,%20%CE%91%CE%B8%CE%AE%CE%BD%CE%B1%20105%2064+(Grande%20Bretagne%20Hotel)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed" width="100%" height= "300px"></iframe>
            </section>    
    </main>
    <footer class="margin-top">
        <p> &copy; ΔΙΠΑΕ 2021</p>
    </footer>
    <link href="css_files/room-page.css" type="text/css" rel="stylesheet" />
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
</body>
