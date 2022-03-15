<?php
$room_id = $_POST["room_id"];
$rate = $_POST["rate"];
$userId = $_POST["user_id"];
$comment = $_POST["comment"];

$con =mysqli_connect("127.0.0.1", "hotel", "password", "hotel");

$notReady = empty($rate) || empty($comment);
if (!$notReady) {
    mysqli_query($con, "INSERT INTO review (room_id, user_id, rate, comment) VALUES ('$room_id', '$userId' ,'$rate', '$comment')");
    echo "Thanks for your review!";
} else {
    echo "Please fill both fields";
}

