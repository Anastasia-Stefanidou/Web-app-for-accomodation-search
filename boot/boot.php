<?php

error_reporting(E_ERROR);

spl_autoload_register(function ($class) {
    $class = str_replace("\\", "/", $class);
    // var_dump(sprintf('app/%s.php', $class));
    require_once sprintf(__DIR__.'/../app/%s.php', $class);

});

use Hotel\User;

$user = new User();

if(isset($_COOKIE['user_token'])) {
    $userToken = $_COOKIE['user_token'];
};
if(isset($_COOKIE['user_token']))
{
    if ($userToken) {
        if ($user->verifyToken($userToken)) {
            //set user in memory
            $userInfo = $user->getTokenPayload($userToken);
            User::setCurrentUserId($userInfo['user_id']);
        }
    }
};
