<?php
session_start();
$DATABASE_HOST = "127.0.0.1";
$DATABASE_USER = "hotel";
$DATABASE_PASS = "password";
$DATABASE_NAME = "hotel";

$con =mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_errno() ) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if(session_destroy()) {
    header ("Location: ../index.php");
}
?>