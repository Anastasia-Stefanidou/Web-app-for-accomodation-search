<?php

require __DIR__.'/../boot/boot.php';

use Hotel\Room;
use Hotel\RoomType;

$room = new Room();
$cities = $room->getCities();
// print_r($cities);die;

$type = new RoomType();
$allTypes = $type->getAllTypes();
// print_r($allTypes);die;

$allAvailableRooms = $room->search(new DateTime($checkInDate),new DateTime($checkOutDate), $selectedCity, $selectedTypeId);

?>

<!DOCTYPE>
<html>
  <head>
    <meta name="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <title>Home Page</title>
    <link
      rel="stylesheet"
      href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css"
    />
    <link rel="stylesheet" href="css_files/basic_styles.css">
    <link rel="stylesheet" href="css_files/index.css">
  </head>
  <body>
    <header>
          <nav class="navbar">
              <ul>
                  <li class="navbar-logo">TravelBug</li>
                  <li class="navbar-toggle"><i class="fas fa-bars"></i></li>
                  <li class="navbar-links current_page"><a href="#">Home</a></li>
                  <li class="navbar-links"><a href="profile.php" target="_blank">Profile</a></li>
                  <li class="navbar-links"><a href="register.php">Register</a></li>
                  <li class="navbar-links"><a href="login.php">Log In</a></li>
              </ul>
          </nav>
      </header>
    <main>
        <form class="container" name = "searchForm" action="list.php" method="GET">
            <select class="item item1" name="city" id="city" data-placeholder="City">
                <option value="" disabled selected hidden>City</option>
                <?php
                    foreach ($cities as $city) {
                  ?>
                    <option value="<?php echo $city; ?>"><?php echo $city; ?></option>
                  <?php
                    }
                  ?>
             </select>
             <select class="item item2" name="room_type" id="RoomType" data-placeholder="Room Type">
                <option value="" disabled selected hidden>Room Type</option>
                <?php
                   foreach ($allTypes as $roomType) {
                 ?>
                   <option value="<?php echo $roomType['type_id']; ?>"><?php echo $roomType['title']; ?></option>
                <?php
                  }
                ?>
              </select>
              <input class="item item3" type="date"  name="check_in_date" id="from" placeholder="Check-in Date">
              <input class="item item4" type="date" name="check_out_date" id="to" placeholder="Check-out Date">
              <div class="search_btn">
                  <input id="submitButton" type="submit" value="Search"/>
              </div>
        </form>
    </main>
    <footer>
          <p> &copy; ΔΙΠΑΕ 2021</p>
    </footer>
    <script src="js_files/responsive_navbar.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  </body>
</html>
