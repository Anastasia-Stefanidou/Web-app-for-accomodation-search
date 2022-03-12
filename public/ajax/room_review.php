<?php

use Hotel\User;
use Hotel\Review;

//Boot application
require_once __DIR__ .'/../../boot/boot.php';


//Return to home page if not a post request
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    die;
} 

//If no user is logged in, return to main page
if (empty(User::getCurrentUserId())) {
    die;
}

//Check if room id is given
$roomId = $_REQUEST['room_id'];
if (empty($roomId)) {
    die;
}

//Add review
$review = new Review();
$review->addReview($roomId, User::getCurrentUserId(), $_REQUEST['rate'], $_REQUEST['comment']);

//Get all reviews
$roomReviews = $review->getReviewsByRoom($roomId);

//Load user
$user = new User();
$userInfo = $user->getByUserId(User::getCurrentUserId());

?>

<div class="room_reviews">
    <div class="content_left">
        <span><?php echo $userInfo['name']; ?></span>
    </div>
    <div class="content_right">
        <h5><?php echo (new DateTime())->format('Y-m-d H:i:s'); ?></h5>
        <?php 
            for ($i=1; $i <= 5; $i++) { 
                if ($_REQUEST['rate'] >= $i) {
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
        <p><?php echo $_REQUEST['comment']; ?></p>
    </div>
</div>