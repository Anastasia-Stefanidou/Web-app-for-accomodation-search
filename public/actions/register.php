<?php

//Boot application
require_once __DIR__.'/../../boot/boot.php';

use Hotel\User;

if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    header('Location: /');

    return;
}

$user = new User();

$checkEmail = $user->checkIfEmailExists($_REQUEST['email']);
$passLength = strlen((int) ($_REQUEST['password']));

if (empty($checkEmail)) {
    if ($passLength > 4) {
        $user->insert($_REQUEST['name'], $_REQUEST['email'], $_REQUEST['password']);
        header('Location: /public/index.php');
    } else {
        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Password must be more than 4 characters!');
        window.location.href='../register.php';
        </script>");
    }
} else {
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('User already exists!');
    window.location.href='../register.php';
    </script>");
}

$userInfo = $user->getByEmail($_REQUEST['email']);

// Generate Token
$token = $user->generateToken($userInfo['user_id']);

//Set cookie
setcookie('user_token', $token, time() + (30 * 24 * 60 * 60), '/');
