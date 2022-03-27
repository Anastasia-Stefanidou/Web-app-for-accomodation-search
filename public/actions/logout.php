<?php  
  
if (isset($_COOKIE['user_token'])) {
    unset($_COOKIE['user_token']);
    setcookie('user_token', '', time() - 3600, '/'); // empty value and old timestamp
    header('Location: ../index.php');
}
?>  