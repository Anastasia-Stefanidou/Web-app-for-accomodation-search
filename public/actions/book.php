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
if (!empty(User::getCurrentUserId())) {
    echo "no user";
    header('Location: /');
    
    return;
}

//Check if room id is given
$roomId = $_REQUEST['room_id'];
if (empty($roomId)) {
    header('Location: /');
    
    return;
}

//Create Booking
$booking = new Booking();
$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];
$booking->insert($roomId, User::getCurrentUserId(), $checkInDate, $checkOutDate);

//Return to home page
header(sprintf('Location: /room.php?room_id=%s', $roomId));