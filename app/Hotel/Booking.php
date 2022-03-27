<?php

namespace Hotel;

use PDO;
use Hotel\BaseService;
use DateTime;

class Booking extends BaseService {
    public function getByUser($userId) {
        $parameters = [
            ':user_id' => $userId,
        ];
        return $this->fetchAll('SELECT booking.*, room.name, room.city, room.area, room.description_short, room.photo_url, room_type.title as room_type
        FROM booking
        INNER JOIN room ON booking.room_id = room.room_id
        INNER JOIN room_type ON room.type_id = room_type.type_id
        WHERE user_id = :user_id', $parameters);
    }

    // public function getroomId($userId) {
    //     $parameters = [
    //         ':user_id' => $userId,
    //     ];
    //     return $this->fetchAll('SELECT room.room_id
    //     FROM room
    //     INNER JOIN booking ON booking.room_id = room.room_id
    //     WHERE user_id = :user_id', $parameters);
    // }

    // public function getBookingId($roomId) {
    //     $parameters = [
    //         ':room_id' => $roomId,
    //     ];
    //     return $this->fetchAll('SELECT booking.booking_id
    //     FROM booking
    //     INNER JOIN payment ON booking.booking_id = payment.booking_id
    //     WHERE room_id = :room_id', $parameters);
    // }

    public function bookingDetails($roomId, $userId, $checkInDate, $checkOutDate) {
        $this->getPdo()->beginTransaction();
        $parameters = [
            ':room_id' => $roomId,
        ];
        $roomInfo = $this->fetch('SELECT * FROM room WHERE room_id = :room_id', $parameters);
        $price = $roomInfo['price'];

        //Step 3, Calculate final price
        $checkInDateTime = new DateTime($checkInDate);
        $checkOutDateTime = new DateTime($checkOutDate);
        $daysDiff = $checkOutDateTime->diff($checkInDateTime)->days;
        return $totalPrice = $price * $daysDiff;
    }

    public function addBooking($roomId, $userId, $checkInDate, $checkOutDate) {
        //Step 1, Begin Transaction
        $this->getPdo()->beginTransaction();

        //Step 2, Get room info
        $parameters = [
            ':room_id' => $roomId,
        ];
        $roomInfo = $this->fetch('SELECT * FROM room WHERE room_id = :room_id', $parameters);
        $price = $roomInfo['price'];

        //Step 3, Calculate final price
        $checkInDateTime = new DateTime($checkInDate);
        $checkOutDateTime = new DateTime($checkOutDate);
        $daysDiff = $checkOutDateTime->diff($checkInDateTime)->days;
        $totalPrice = $price * $daysDiff;
        $year = $_POST['year'];
        $month = $_POST['month'];
        $CVC = $_POST['CVC'];
        $card = $_POST['card'];
        //Step 4, Book room
        $parameters = [
            ':room_id' => $roomId,
            ':user_id' => $userId,
            ':total_price' => $totalPrice,
            ':check_in_date' => $checkInDate,
            ':check_out_date' => $checkOutDate,
            ':year' => $year,
            ':month' => $month,
            ':CVC' => $CVC,
            ':card' => $card,
        ];

        $this->execute('INSERT INTO booking (room_id, user_id, total_price, check_in_date, check_out_date, card, month, year, cvc) VALUES (:room_id, :user_id, :total_price, :check_in_date, :check_out_date, :card, :month, :year, :CVC)', $parameters);

        //Step 5, commit

        return $this->getPdo()->commit();
    }

    public function isBooked($roomId, $checkInDate, $checkOutDate) {

        $parameters = [
            ':room_id' => $roomId,
            ':check_in_date' => $checkInDate,
            ':check_out_date' => $checkOutDate,
        ];

        $rows = $this->fetchAll('SELECT room_id
                FROM booking
                WHERE room_id = :room_id AND check_in_date <=:check_out_date AND check_out_date >= :check_in_date', 
                    $parameters);

        return count($rows) > 0;
    }

    public function getInfo($roomId) {
        $parameters = [
            ':room_id' => $roomId,
        ];
        return $this->fetch('SELECT * FROM booking WHERE room_id = :room_id', $parameters);
    }

    public function UserBookingInfo($roomId, $userId) {
        $parameters = [
            ':room_id' => $roomId,
            ':user_id' => $userId,
        ];
        $rows = $this->fetchAll('SELECT * FROM booking WHERE room_id = :room_id AND user_id = :user_id', $parameters);
        return count($rows);
    }

}