<?php
require __DIR__.'/../boot/boot.php';

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
    <title>Login Page | TravelBug</title>
</head>
<body>
    <header>
        <nav class="navbar">
            <ul>
                <li class="navbar-logo"><a href="index.php">TravelBug</a></li>
                <li class="navbar-toggle"><i class="fas fa-bars"></i></li>
                <li class="navbar-links"><a href="index.php">Home</a></li>
                <li class="navbar-links"><a href="profile.php" target="_blank">Profile</a></li>
                <li class="navbar-links"><a href="register.php">Register</a></li>
                <li class="navbar-links current_page"><a href="#">Log in</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <form method="post" action="actions/login.php" class="form">
            <h1>Login</h1>
            <input id="name" type="text" name="name" placeholder="Username" required/>
            <input id="password" type="password" name="password" placeholder="Password" required/>
            <input class="cta" type="submit" name="submit" value="LOGIN" />
            <h2>Not a member?<span style ="font-weight: bold"><a href = "register.php" target= "_blank"> Sign up now</a></span></h2>
        </form>
    </main>
    <footer>
        <p> &copy; ΔΙΠΑΕ 2022</p>
     </footer>
     <script src="js_files/responsive_navbar.js"></script>
     <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
</body>
</html>

