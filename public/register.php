<?php
session_start();

require __DIR__.'/../boot/boot.php';

use Hotel\User;

// Check for existing logged in user
// if (!empty(User::getCurrentUserId())) {
//   header('Location: /public/index.php');die;
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
    rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="css_files/login.css">
    <link rel="stylesheet" href="css_files/basic_styles.css">
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.13.0/css/all.css"
      integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V"
      crossorigin="anonymous"
    />
    <title>Register Page | TravelBug</title>
</head>
<body>
    <header>
        <nav class="navbar">
            <ul>
                <li class="navbar-logo"><a href="index.php">TravelBug</a></li>
                <li class="navbar-toggle"><i class="fas fa-bars"></i></li>
                <li class="navbar-links"><a href="index.php">Home</a></li>
                <li class="navbar-links"><a href="profile.php" target="_blank">Profile</a></li>
                <li class="navbar-links current_page"><a href="#">Register</a></li>
                <li class="navbar-links"><a href="login.php">Log in</a></li>
            </ul>
        </nav>
    </header>
    <main class="parent">
        <form action="actions/register.php" method="post" class="registerForm form">
            <?php if(isset($_GET['error'])) { ?>
                <div class="alert alert-danger alert-styled-left">Register Error</div>
            <?php } ?> 
            <h1 class="extra_style">Create your account</h1>
            <input id="name" type="text" name="name" placeholder="Name" required/>
            <input id="email" type="email" name="email" placeholder="Email" required/>
            <input id="password" type="password" name="password" placeholder="Password" required/>
            <button class="btn" type="submit" name="submit">Register</button>
            <h2>Already a member?<span style ="font-weight: bold"><a href = "login.php" target= "_blank"> Log in</a></span></h2>
        </form>
    </main>
    <footer>
        <p> &copy; ΔΙΠΑΕ 2022</p>
     </footer>
     <!-- <script src="js_files/form_validation.js"></script> -->
     <script src="js_files/responsive_navbar.js"></script>
</body>
</html>

