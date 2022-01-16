<?php

namespace Hotel;

use PDO;
use DateTime;
use Hotel\BaseService;
use support\configuration\configuration;

class Guests extends BaseService 
{
     public function getAllGuests()
         {
             $guests = [];
             $rows = $this->fetchAll('SELECT DISTINCT count_of_guests FROM room');

               foreach ($rows as $row) {
                   $guests[] = $row['count_of_guests'];
               }
               return $guests;

         }
                 
  }