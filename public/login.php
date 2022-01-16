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
    <title>Login Page</title>
</head>
<body>
    <header>
        <nav class="navbar">
            <ul>
                <li class="navbar-logo">TravelBug</li>
                <li class="navbar-toggle"><i class="fas fa-bars"></i></li>
                <li class="navbar-links"><a href="index.php">Home</a></li>
                <li class="navbar-links"><a href="profile.php" target="_blank">Profile</a></li>
                <li class="navbar-links"><a href="register.php">Register</a></li>
                <li class="navbar-links current_page"><a href="#">Log in</a></li>
            </ul>
        </nav>
    </header>
    <main class="parent">
        <div class="container">
            <div class="content-left">
                <form action="actions/login.php" method="post" class="form">
                    <h1>Login</h1>
                    <input id="name" type="text" name="username" placeholder="Username" required/>
                    <input id="password" type="password" name="password" placeholder="Password" required/>
                    <input class="cta" type="submit" name="submit" value="LOGIN" />
                    <h2>Not a member?<span style ="font-weight: bold"><a href = "register.php" target= "_blank"> Sign up now</a></span></h2>
                </form>
            </div>
            <div class="content-right">
                <div class="img">
                    <div class="img_area"></div>
                    <h2 class="tracking-in-expand">Your first<br>step to<br>creating<br>new<br>memories!</h2>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <p> &copy; ΔΙΠΑΕ 2021</p>
     </footer>
     <script src="js_files/responsive_navbar.js"></script>
</body>
</html>