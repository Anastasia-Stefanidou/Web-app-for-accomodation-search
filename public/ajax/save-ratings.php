<?php
$room_id = $_POST["room_id"];
$rate = $_POST["rate"];
$userId = $_POST["user_id"];
$comment = $_POST["comment"];

$DATABASE_HOST = "127.0.0.1";
$DATABASE_USER = "hotel";
$DATABASE_PASS = "password";
$DATABASE_NAME = "hotel";

$con =mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

mysqli_query($con, "INSERT INTO review (room_id, user_id, rate, comment) VALUES ('$room_id', '$userId' ,'$rate', '$comment')");

echo "Saved";