<?php

require __DIR__.'/../boot/boot.php';

use Hotel\Favorite;
use Hotel\Review;
use Hotel\Booking;
use Hotel\User;

//Checked for logged in user
// if (empty(User::getCurrentUserId())) {
//   header('Location: index.php');

//   return;
// }

// $favorite = new Favorite();
// $userFavorites = $favorite->getListByUser($userId);

// $review = new Review();
// $userReviews = $review->getListByUser($userId);
// print_r($userReviews);die;

?>
<!DOCTYPE>
<html>
<head>
    <meta name="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <title>Profile-page</title>
</head>
<body>
    <header>
        <div class="box-shadow">
            <span class="main-logo">Hotels</span>
          <div class="primary-menu text-right">
              <ul>
                    <li id="divleft">
                        <a href="profile.html" target="_blank">
                          <i class="fas fa-user"></i>
                          Profile
                      </a>
                    </li>
                    <li id="divright">
                        <a href="project.html" target="_blank">
                          <i class="fas fa-home"></i>
                          Home
                        </a>
                    </li>
              </ul>
          </div>
        </div>
    </header>
    <main class="main-content">
              <div class="container">
                <section class="favorites">
                    <p>FAVORITES</p>
                    <!-- <?php
                        if (count($userFavorites) > 0) {
                    ?> -->
                    <ol>
                      <!-- <?php
                          foreach ($userFavorites as $favorite) {
                      ?> -->
                      <h3>
                        <li>
                          <h3>
                              <a href="/room.php?room_id=<?php echo $favorite['room_id']; ?>"><?php echo $favorite['name']; ?></a>
                          </h3>
                        </li>
                      </h3>
                      <?php
                          }
                      ?>
                    </ol>
                    <?php
                        } else {
                    ?>
                        <h4>You don't have any favorite Hotel!</h4>
                    <?php
                        }
                    ?>
                 </section>
                  <section class="reviews">
                    <p class="last-paragraph">REVIEWS</p>
                    <ol>
                        <li>Hilton Hotel</li>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <li>Grande Bretagne Hotel</li>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </ol>
                </section>
              <section class="hotel-list inline-block align-top">
                      <header class="page-title">
                          <h2>My Bookings</h2>
                      </header>
                      <article class="hotel">
                        <aside class="media">
                           <img src="/../extra/images/room-2.jpg" alt="Welcome to our site" width="100%" height="auto">
                            <!-- <div class="pricebutton"> -->
                                <button class="price">Total Cost: 500 &euro; </button>
                            <!-- </div> -->
                       </aside>
                        <main class="info">
                          <div class="border-line">
                               <h2>GRANDE BRETAGNE HOTEL</h2>
                               <h3><i class="fas fa-map-marker-alt"></i>
                                 ATHENS, SYNTAGMA</h3>
                               <p>The grand hotel grand Bretagne is a historic luxury hotel in the heart of Athens</p>
                          </div>
                               <div class="buttonright">
                                 <button class="room-page"><a href="rooms-page.html" target="_blank">Go to Room Page</a></button>
                               </div>
                               <div class="box smallbox">
                                   <span class="grayboxleft">Check-in Date: 2018-04-27 </span>
                                   <span class="grayboxmiddle">Check-out Date: 2018-04-30</span>
                                   <span class="grayboxright">Type of Room: Double Room</span>
                              </div>
                         </main>
                        <div class="clear"></div>
                      </article>
                      <article class="hotel">
                        <aside class="media">
                           <img src="/../extra/images/room-1.jpg" alt="Welcome to our site" width="100%" height="auto">
                             <!-- <div class="box"> -->
                                <button class="price">Total Cost: 350 &euro; </button>
                             <!-- </div> -->
                       </aside>
                        <main class="info">
                          <div class="border-line">
                                 <h2>HILTON HOTEL</h2>
                                 <h3><i class="fas fa-map-marker-alt"></i>
                                   ATHENS, ZWGRAFOU</h3>
                                 <p>Private balconies with Acropolis and city views provide a stunning backdrop and natural light.</p>
                          </div>
                               <div class="buttonright">
                                 <button class="room-page"><a href="rooms-page.html" target="_blank">Go to Room Page</a></button>
                               </div>
                               <div class="box smallbox">
                                 <span class="grayboxleft">Check-in Date: 2018-06-20 </span>
                                 <span class="grayboxmiddle">Check-out Date: 2018-09-25</span>
                                 <span class="grayboxright">Type of Room: Single Room</span>
                              </div>
                         </main>
                         <div class="clear"></div>
                      </article>
                   </section>
                </div>
    </main>
    <footer>
        <p> &copy; ΔΙΠΑΕ 2021</p>
    </footer>
  <link href="css_files/profile-page.css" type="text/css" rel="stylesheet" />
</body>
</html>
