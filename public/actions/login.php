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
// $uname = $_POST['username'];
// $password = $_POST['password'];
if (!isset($_POST['username'], $_POST['password']) ) {
    exit('Please fill both username and password fields!');
}

if ($stmt = $con->prepare('SELECT user_id, password FROM user WHERE name = ?')) {
    // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    // Store the result so we can check if the account exists in the database.
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $password);
        $stmt->fetch();
        // Account exists, now we verify the password.
        // Note: remember to use password_hash in your registration file to store the hashed passwords.
        if (password_verify($_POST['password'], $password)) {
            // Verification success! User has logged-in!
            // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['user_id'] = $user_id;
            header('Location: /public/profile.php');
        } else {
            // Incorrect password
            // echo 'Incorrect username and/or password!';
            echo '<script type= "text/javascript">';
            echo 'alert("Invalid password!")';
            // echo 'window.location.href = "/public/index.php" ';
            echo '</script>';
        }
    } else {
        // Incorrect username
        echo 'Incorrect username and/or password!';
    }

    $stmt->close();
}
?>