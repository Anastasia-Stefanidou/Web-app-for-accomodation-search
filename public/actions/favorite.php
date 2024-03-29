<?php

use Hotel\User;
use Hotel\Favorite;

require_once __DIR__.'/../../boot/boot.php';

//Return to home page if not a post request
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    // header('Location: /');
    // return;

    echo "This is a post script!";
    die;
}

//If no user is logged in, return to main page
if (empty(User::getCurrentUserId())) {
    // header('Location: /');
    // return;

    echo "No current user for this operation!";
    die;
}

//Check if room id is given
$roomId = $_REQUEST['room_id'];
if (empty($roomId)) {
    // header('Location: /');
    // return;

    echo "No room is given for this operation!";
    die;
}

//Set room to favorites
$favorite = new Favorite();

$isFavorite = $_REQUEST['is_favorite'];
if (!$isFavorite) {
    $status = $favorite->addFavorite($roomId, User::getCurrentUserId());
} else {
    $favorite->removeFavorite($roomId, User::getCurrentUserId());
}

//Return to home page
header(sprintf('Location: ../room.php?room_id=%s', $roomId));
