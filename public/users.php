<?php

require_once __DIR__.'/../autoload.php';

use Hotel\User;

$user = new User();
// $list = $user->getList();
// print_r($list);



// create new user
// $status = $user->insert('Jimmy', 'jimmy@example.com', 'password123');
// var_dump($status);

// $list = $user->getList();
// print_r($list);

$verified = $user->verify('jimmy@example.com', 'password123');
var_dump($verified);




