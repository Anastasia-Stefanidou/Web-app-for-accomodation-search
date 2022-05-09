<?php

use Hotel\User;
use Hotel\Booking;

require_once __DIR__.'/../../boot/boot.php';

//Return to home page if not a post request
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    header('Location: /');   
    return;
}

//If there is already logged in user, return to main page
if (empty(User::getCurrentUserId())) {
    header('Location: /');
    return;
}

//Check if room id is given
$roomId = $_REQUEST['room_id'];
if (empty($roomId)) {
    header('Location: /');  
    return;
}

function function_alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

//Create Booking
$booking = new Booking();
$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];
$year = $_REQUEST['year'];
$month = $_REQUEST['month'];
$CVC = $_REQUEST['CVC'];
$card = $_REQUEST['card'];

$failed = empty($checkInDate) || empty($checkOutDate) || empty($year) || empty($month) || empty($CVC) || empty($card);
if (!$failed) {
    $booking->addBooking($roomId, User::getCurrentUserId(), $checkInDate, $checkOutDate);
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('Congratulations!Booking confirmed.');
    window.location.href='../profile.php';
    </script>");
} else {
    function_alert("Please fill correctly all fields.");
    // echo "<p style='font-size:20px;'>Please fill correctly all fields</p>";
    // echo "Please fill correctly all fields";
}

//Return to home page
// header(sprintf('Location: ../profile.php'));
// header(sprintf('Location: ../room.php?room_id=%s&check_in_date=%s&check_out_date=%s', $roomId, $checkInDate, $checkOutDate));