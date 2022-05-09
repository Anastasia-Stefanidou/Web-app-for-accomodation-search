<?php
//Boot application
require_once __DIR__.'/../../boot/boot.php';

use Hotel\User;

$user = new User();

$verifiedUser = $user->verifyUser($_REQUEST['name'], $_REQUEST['password']);
if (!$verifiedUser) {
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('Wrong username or password.');
    window.location.href='../login.php';
    </script>");
} else {
    $userInfo = $user->getByName($_REQUEST['name']);
    // Generate Token
    $token = $user->generateToken($userInfo['user_id']);
    // Set cookie
    setcookie('user_token', $token, time() + (30 * 24 * 60 * 60), '/');
    header('Location: ../profile.php');
}

?>