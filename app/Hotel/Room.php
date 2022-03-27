<?php

namespace Hotel;

use PDO;
use DateTime;
use Hotel\BaseService;


class Room extends BaseService {
    public function get($roomId) {
        $parameters = [
            ':room_id' => $roomId,
        ];
        return $this->fetch('SELECT * FROM room WHERE room_id = :room_id', $parameters);
    }

    public function getAllGuests() {
        $guests = [];
        $rows = $this->fetchAll('SELECT DISTINCT count_of_guests FROM room');

          foreach ($rows as $row) {
              $guests[] = $row['count_of_guests'];
          }
          return $guests;

    }
    
    public function getCities() {
        //Get all cities
        $cities = [];
        $rows = $this->fetchAll('SELECT DISTINCT city FROM room');
        foreach ($rows as $row) {
            $cities[] = $row['city'];
        }

        return $cities;
    }

    public function search ($checkInDate, $checkOutDate, $selectedCity = '', $selectedTypeId = '', $selectedGuest = '') {
        //Setup parameters
        $parameters = [
            ':check_in_date' => $checkInDate->format(DateTime::ATOM),
            ':check_out_date' => $checkOutDate->format(DateTime::ATOM),
        ];

        if($checkInDate > $checkOutDate) {
            header('Location: ../public/index.php');
            return;
        } else {
            if (!empty($selectedCity)) {
                $parameters[':city'] = $selectedCity;
            }
            if (!empty($selectedTypeId)) {
                $parameters[':type_id'] = $selectedTypeId;
            }
            if (!empty($selectedGuest)) {
                $parameters[':count_of_guests'] = $selectedGuest;
            }
    
            //Build query
            $sql = 'SELECT * FROM room WHERE ';
    
            if (!empty($selectedCity)) {
                $sql .= 'city = :city AND ';
            }
    
            if (!empty($selectedTypeId)) {
                $sql .= 'type_id = :type_id AND ';
            }
            if (!empty($selectedGuest)) {
                $sql .= 'count_of_guests = :count_of_guests AND ';
            }
    
            $sql .= 'room_id NOT IN (
                    SELECT room_id
                    FROM booking
                    WHERE check_in_date <=:check_out_date AND check_out_date >= :check_in_date
            )';
    
            //Get results
            $result = $this->fetchAll($sql, $parameters);
            // $print_r($result);die;
    
            return $this->fetchAll($sql, $parameters);
        }
    }
}

