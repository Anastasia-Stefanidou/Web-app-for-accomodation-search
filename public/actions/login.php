<?php
//Boot application
require_once __DIR__.'/../../boot/boot.php';

use Hotel\User;

// if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
//     header('Location: /');

//     return;
// }
function function_alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

$user = new User();

$verifiedUser = $user->verifyUser($_REQUEST['name'], $_REQUEST['password']);
// print_r($verifiedUser);die;

if (!$verifiedUser) {
    function_alert("Wrong username or password");
} else {
    $userInfo = $user->getByName($_REQUEST['name']);
    // Generate Token
    $token = $user->generateToken($userInfo['user_id']);
    // Set cookie
    setcookie('user_token', $token, time() + (30 * 24 * 60 * 60), '/');
    header('Location: ../profile.php');
}

//Return to home page
// header('Location: /public/index.php');
?>