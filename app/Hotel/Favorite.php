<?php

namespace Hotel;

use Hotel\BaseService;


class Favorite extends BaseService {
    
    public function getByUser($userId) {
        $parameters = [
            ':user_id' => $userId,
        ];
        return $this->fetchAll('SELECT favorite.*, room.name, room.photo_url
        FROM favorite
        INNER JOIN room ON favorite.room_id = room.room_id
        WHERE user_id = :user_id', $parameters);
    }

    public function isFavorite($roomId, $userId) {
        $parameters = [
            ':room_id' => $roomId,
            ':user_id' => $userId,
        ];
        $favorite = $this->fetch('SELECT * FROM favorite WHERE room_id = :room_id AND user_id = :user_id', $parameters);

        return !empty($favorite);
    }

    public function addFavorite($roomId, $userId) {  
           $parameters = [
               ':room_id' => $roomId,
               ':user_id' => $userId,
           ];
           
           return $this->execute('INSERT IGNORE INTO favorite (room_id, user_id) VALUES 
           (:room_id, :user_id)', $parameters);
       }

    public function removeFavorite($roomId, $userId) {
        $parameters = [
            ':room_id' => $roomId,
            ':user_id' => $userId,
        ];

        $rows = $this->execute('DELETE FROM `favorite` WHERE room_id = :room_id AND user_id = :user_id', $parameters);

        return $rows == 1;
    }
}
