<?php

require __DIR__.'/../boot/boot.php';

use Hotel\User;

//Get Users
$user = new User();
$userRecord = $user->getByEmail('john@doe.com');
print_r($userRecord);


