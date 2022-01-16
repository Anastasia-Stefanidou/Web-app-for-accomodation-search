<?php

//Boot application
require_once __DIR__.'/../../boot/boot.php';

use Hotel\User;

if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    header('Location: /');

    return;
}

$user = new User();
$user->insert($_REQUEST['name'], $_REQUEST['email'], $_REQUEST['password']);

// Retrieve user
$userInfo = $user->getByEmail($_REQUEST['email']);

// Generate Token
$token = $user->generateToken($userInfo['user_id']);

//Set cookie
setcookie('user_token', $token, time() + (30 * 24 * 60 * 60), '/');

//Return to home page
header('Location: /public/index.php');
