<?php
require __DIR__.'/../boot/boot.php';
use Hotel\Room;
use Hotel\RoomType;
use Hotel\User;

$user = new User();

$room = new Room();
$cities = $room->getCities();

$type = new RoomType();
$allTypes = $type->getAllTypes();

$allAvailableRooms = $room->search(new DateTime($checkInDate),new DateTime($checkOutDate), $selectedCity, $selectedTypeId);
$userId = User::getCurrentUserId();
?>

<!DOCTYPE>
<html>
  <head>
    <meta name="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <title>Home Page | TravelBug</title>
    <link
      rel="stylesheet"
      href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css"
    />
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.13.0/css/all.css"
      integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="css_files/basic_styles.css">
    <link rel="stylesheet" href="css_files/index.css">
  </head>
  <body>
    <header>
          <nav class="navbar">
              <ul>
                  <li class="navbar-logo"><a href="index.php">TravelBug</a></li>
                  <li class="navbar-toggle"><i class="fas fa-bars"></i></li>
                  <li class="navbar-links current_page"><a href="#">Home</a></li>
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
              <input class="item item3" type="date"  name="check_in_date" id="from" placeholder="Check-in Date" min="<?php echo date("Y-m-d"); ?>">
              <input class="item item4" type="date" name="check_out_date" id="to" placeholder="Check-out Date" min="<?php echo date("Y-m-d"); ?>">
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
