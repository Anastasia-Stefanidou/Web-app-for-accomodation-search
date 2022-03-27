<?php

require __DIR__.'/../boot/boot.php';

use Hotel\Room;
use Hotel\User;
use Hotel\RoomType;
use Hotel\Guests;

//Initialize room service
$room = new Room();
$type = new RoomType();
$guest = new Guests();

//Get page parameters
$cities = $room->getCities();
$allTypes = $type->getAllTypes();
$allGuests = $guest->getAllGuests();

$selectedCity = $_REQUEST['city'];
$selectedGuest = $_REQUEST['count_of_guests'];
$selectedTypeId = $_REQUEST['room_type'];
$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];

$allAvailableRooms = $room->search(new DateTime($checkInDate),new DateTime($checkOutDate), $selectedCity, $selectedTypeId, $selectedGuest);

// Get current user id
$userId = User::getCurrentUserId();
?>

<!DOCTYPE>
<html lang="en">
<head>
  <meta name="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex,nofollow">
  <title>Search Page | TravelBug</title>
  <link rel="stylesheet" href="css_files/basic_styles.css">
  <link rel="stylesheet" href="css_files/list.css">
   <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.13.0/css/all.css"
      integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V"
      crossorigin="anonymous"
    />
</head>
<body>
    <header>
        <nav class="navbar">
            <ul>
                <li class="navbar-logo"><a href="index.php">TravelBug</a></li>
                <li class="navbar-toggle"><i class="fas fa-bars"></i></li>
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
  <main>
    <form class= "item item1 container1 searchForm" name = "searchForm" action="list.php" method="get">
        <p>find the perfect hotel</p>
        <select id="count_of_guests" name="count_of_guests" class="cont_item1 cont_item" data-placeholder="Count of Guests">
            <option value="" disabled selected hidden>Count of Guests</option>
            <?php
                foreach ($allGuests as $guest) {
              ?>
               <option <?php echo $selectedGuest == $guest ? 'selected' : ''; ?> value= "<?php echo $guest; ?>"><?php echo $guest;?></option>
            <?php
              }
            ?>
        </select>
        <select name="room_type" data-placeholder= "Room Type" class="cont_item2 cont_item">
            <option value="" disabled selected hidden>Room Type</option>
            <?php
                foreach ($allTypes as $roomType) {
              ?>
                <option <?php echo $selectedTypeId == $roomType['type_id'] ? 'selected' : ''; ?> value="<?php echo $roomType['type_id']; ?>"><?php echo $roomType['title'];?></option>
            <?php
              }
            ?>
        </select>
        <select name="city" data-placeholder="City" class="cont_item3 cont_item">
            <option value="" disabled selected hidden>City</option>
              <?php
                  foreach ($cities as $city) {
              ?>
                    <option <?php echo $selectedCity == $city ? 'selected' : ''; ?> value="<?php echo $city; ?>"><?php echo $city;?></option>
              <?php
                }
              ?>
        </select>
        <input type="date"  name="check_in_date" id="from" value="<?php echo $checkInDate; ?>" placeholder="Check-in Date" class="cont_item4 cont_item" >
        <input type="date" name="check_out_date" id="to" value="<?php echo $checkOutDate; ?>" placeholder="Check-out Date" class="cont_item5 cont_item" min="<?php echo date("Y-m-d"); ?>">
        <input class="cont_item6 cont_item btn" id="submitButton" name="submit" type="submit" value="FIND HOTELS"/>    
    </form>
    <div class= "item item2 container2">
        <h2 class="title">Search Results</h2>
        <?php
            foreach ($allAvailableRooms as $availableRoom) {
        ?>
        <div class="hotel">
            <div class="media">
                <img src="/../extra/images/<?php echo $availableRoom['photo_url']; ?> " alt="room_photo"> 
                <span class="price">Per night: <?php echo $availableRoom['price']; ?> &euro;</span>
            </div>
            <div class="info">
                <h2><?php echo $availableRoom['name']; ?></h2>
                <h3><i class="fas fa-map-marker-alt"></i>
                    <?php echo $availableRoom['city']; ?> , <?php echo $availableRoom['area']; ?>
                    </h3>
                    <p><?php echo $availableRoom['description_short']; ?></p>
                    <div class="extra">
                        <span class= "extra_item" >Count of Guests: <?php echo $availableRoom['count_of_guests']; ?></span>
                        <span class= "extra_item">Type of Room: <?php echo $availableRoom['type_id']; ?></span>
                        <form name="listForm" method="post" action="room.php">
                            <button class="room-page"><a href="room.php?room_id=<?php echo $availableRoom['room_id']; ?>&check_in_date=<?php echo $checkInDate; ?>&check_out_date=<?php echo $checkOutDate; ?>" target="_blank">Go to Room Page</a></button>
                        </form>
                    </div>
            </div>
        </div>
        <?php
            }
        ?>
        <section class="no_rooms">
            <?php
                if(count($allAvailableRooms) == 0) {
            ?>
                <div id="error-box">
                    <div class="dot"></div>
                    <div class="dot two"></div>
                    <div class="face2">
                    <div class="eye"></div>
                    <div class="eye right"></div>
                    <div class="mouth sad"></div>
               </div>
               <div class="shadow move"></div>
               <div class="message"><h1 class="alert">Sorry,</h1><p>there are no rooms.</div>
              <button class="button-box"><a class="red" href="index.php" target="_blank">try something else</a></button>
            <?php
                }
            ?>
        </section>
    </div>
  </main>
  <footer>
        <p> &copy; ΔΙΠΑΕ 2021</p>
  </footer>
  <!-- <script src="js_files/search.js"></script> -->
  <a href="https://codepen.io/juliepark"></a>
  <script src="js_files/responsive_navbar.js"></script>
  <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
</body>
</html>
