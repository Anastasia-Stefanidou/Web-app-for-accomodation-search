<?php

use Hotel\User;
use Hotel\Review;

require_once __DIR__.'/../../boot/boot.php';

//Return to home page if not a post request
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    echo "This is a post script!";
    die;
}

//If no user is logged in, return to main page
if (empty(User::getCurrentUserId())) {
    echo "No current user for this operation!";
    die;
}

//Check if room id is given
$roomId = $_REQUEST['room_id'];
if (empty($roomId)) {
    header('Location: /');

    return;
}

//Set room to favorites
$review = new Review();
$review->insert($roomId, User::getCurrentUserId(), $_REQUEST['rate'], $_REQUEST['comment']);

//Return to home page
header(sprintf('Location: ../room.php?room_id=%s', $roomId));