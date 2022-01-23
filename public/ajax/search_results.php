<?php

require __DIR__.'/../../boot/boot.php';

use Hotel\Room;
use Hotel\RoomType;
use Hotel\Guests;

//Initialize room service
$room = new Room();
$type = new RoomType();
$guest = new Guests();

//Get page parameters
$cities = $room->getCities();
$allTypes = $type->getAllTypes();
$allGuests = $guest->getAllGuests();

// print_r($selectedCity);die;
$selectedCity = $_REQUEST['city'];
$selectedGuest = $_REQUEST['count_of_guests'];
$selectedTypeId = $_REQUEST['room_type'];
$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];
// $roomId = $_REQUEST['room_id'];
// print_r($selectedGuest);die;
$allAvailableRooms = $room->search(new DateTime($checkInDate),new DateTime($checkOutDate), $selectedCity, $selectedTypeId, $selectedGuest);
// print_r($allAvailableRooms);die;

?>
    <div class= "item item2 container2">
            <h2 class="title">Search Results</h2>
                <?php
                    foreach ($allAvailableRooms as $availableRoom) {
                ?>
            <div class="hotel">
                <div class="media">
                    <img src="/../extra/images/<?php echo $availableRoom['photo_url']; ?> " alt="room_photo">
                    <span class="price">Per night: <?php echo $availableRoom['price']; ?> &euro;</span>
                </div>
                <div class="info">
                    <h2><?php echo $availableRoom['name']; ?></h2>
                    <h3><i class="fas fa-map-marker-alt"></i>
                        <?php echo $availableRoom['city']; ?> , <?php echo $availableRoom['area']; ?>
                        </h3>
                        <p><?php echo $availableRoom['description_short']; ?></p>
                        <div class="extra">
                            <span class= "extra_item" >Count of Guests: <?php echo $availableRoom['count_of_guests']; ?></span>
                            <span class= "extra_item">Type of Room: <?php echo $availableRoom['type_id']; ?></span>
                            <button class="room-page"><a href="room.php" target="_blank">Go to Room Page</a></button>
                        </div>
                </div>
            </div>
            <?php
                }
            ?>
            <section class="no_rooms">
                <?php
                    if(count($allAvailableRooms) == 0) {
                ?>
                    <div id="error-box">
                        <div class="dot"></div>
                        <div class="dot two"></div>
                        <div class="face2">
                        <div class="eye"></div>
                        <div class="eye right"></div>
                        <div class="mouth sad"></div>
                </div>
                <div class="shadow move"></div>
                <div class="message"><h1 class="alert">Sorry,</h1><p>there are no rooms.</div>
                <button class="button-box"><a class="red" href="index.php" target="_blank">try something else</a></button>
                <?php
                    }
                ?>
            </section>
        </div>