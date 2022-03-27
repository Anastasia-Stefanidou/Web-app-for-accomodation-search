<?php

require __DIR__.'/../boot/boot.php';

use Hotel\Room;
use Hotel\User;
use Hotel\Booking;

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

$userId = User::getCurrentUserId();
$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];
$booking = new Booking();
$totalPrice = $booking->bookingDetails($roomId, $userId, $checkInDate, $checkOutDate);

?>

<!DOCTYPE>
<html>
    <head>
        <meta name="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow">
        <link rel="stylesheet" href="css_files/basic_styles.css" />
        <link rel="stylesheet" href="css_files/book.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
        <main>
            <div class="container">
                <h1>Payment info</h1>
                <div class="inlineimage"> <img class="img-responsive images" src="https://cdn0.iconfinder.com/data/icons/credit-card-debit-card-payment-PNG/128/Mastercard-Curved.png"> <img class="img-responsive images" src="https://cdn0.iconfinder.com/data/icons/credit-card-debit-card-payment-PNG/128/Discover-Curved.png"> <img class="img-responsive images" src="https://cdn0.iconfinder.com/data/icons/credit-card-debit-card-payment-PNG/128/Paypal-Curved.png"> <img class="img-responsive images" src="https://cdn0.iconfinder.com/data/icons/credit-card-debit-card-payment-PNG/128/American-Express-Curved.png"></div>
                <form class="bookingForm" name = "bookingForm" method="post" action="actions/book.php">
                    <div class="content-left">
                        <div class="cardDetails">
                            <p class="title">Card number:</p>
                            <i class="fa fa-credit-card"></i>
                            <input type="text" name="card" class="card" placeholder="0000 0000 0000 0000" minlength=16 maxlength=16>
                        </div>
                        <div class="dates">
                            <p class="title">Expiration date:</p>
                            <select name="month">
                                <option value="">--Month--</option>
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                            <select name="year">
                                <option value="">--Year--</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                            </select>
                        </div>
                        <div class="code">
                            <p class="title">CVC:</p>
                            <input name="CVC" class="secCode" placeholder="123" minlength=3 maxlength=3>
                        </div>
                    </div>
                    <div class="content-right">
                        <p>Payment amount: <span class="price"><?php echo $totalPrice ?> €</span></p>
                        <input type="hidden" name = "room_id" value="<?php echo $roomId ?>">
                        <input type="hidden" name = "check_in_date" value="<?php echo $checkInDate ?>">
                        <input type="hidden" name = "check_out_date" value="<?php echo $checkOutDate ?>">
                        <button name="submitForm" type ="submit" class="btn3">Pay now</button>
                    </div>
                </form>
            </div>
        </main>
        <footer class="margin-top">
            <p> &copy; ΔΙΠΑΕ 2021</p>
        </footer>
        <script src="js_files/responsive_navbar.js"></script>
    </body>
</html>