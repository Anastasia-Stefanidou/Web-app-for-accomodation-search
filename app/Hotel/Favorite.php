<?php

namespace Hotel;

use PDO;
use DateTime;
use Hotel\BaseService;


class Favorite extends BaseService 
{
    public function isFavorite($roomId, $userId) {
        $parameters = [
            ':room_id' => $roomId,
            'user_id' => $userId,
        ];
        return $this->fetch('SELECT * FROM favorite WHERE room_id = :room_id AND user_id = :user_id', $parameters);
    }

    public function addFavorite() {

    }

    public function removeFavorite() {

    }
}
