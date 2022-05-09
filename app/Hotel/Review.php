<?php

namespace Hotel;

use PDO;
use Hotel\BaseService;

class Review extends BaseService
{
    public function getByUser($userId) {
        $parameters = [
            ':user_id' => $userId,
        ];
        return $this->fetchAll('SELECT review.*, room.name, room.photo_url
        FROM review
        INNER JOIN room ON review.room_id = room.room_id
        WHERE user_id = :user_id', $parameters);
    }

    public function averageReview($roomId) {
        $this->getPdo()->beginTransaction();

        $parameters = [
            'room_id' => $roomId,
        ];
        $roomAverage = $this->fetch('SELECT avg(rate) as avg_reviews, count(*) as count FROM review WHERE room_id = :room_id', $parameters);

        $parameters = [
            'room_id' => $roomId,
            'avg_reviews' => $roomAverage['avg_reviews'],
            'count_reviews' => $roomAverage['count'],
        ];

        $this->execute('UPDATE room SET avg_reviews = :avg_reviews, count_reviews = :count_reviews WHERE room_id = :room_id', $parameters);

        return $this->getPdo()->commit();
    }

    public function addReview($roomId, $userId, $rate, $comment) {
        $this->getPdo()->beginTransaction();
        $parameters = [
            ':room_id' => $roomId,
            ':user_id' => $userId,
            ':rate' => $rate,
            ':comment' => $comment,
        ];

        $this->execute('INSERT INTO review (room_id, user_id, rate, comment) VALUES (:room_id, :user_id, :rate, :comment)', $parameters);
        
        $parameters = [
            'room_id' => $roomId,
        ];
        $roomAverage = $this->fetch('SELECT avg(rate) as avg_reviews, count(*) as count FROM review WHERE room_id = :room_id', $parameters);

        $parameters = [
            'room_id' => $roomId,
            'avg_reviews' => $roomAverage['avg_reviews'],
            'count_reviews' => $roomAverage['count'],
        ];

        $this->execute('UPDATE room SET avg_reviews = :avg_reviews, count_reviews = :count_reviews WHERE room_id = :room_id', $parameters);

        return $this->getPdo()->commit();
    }

    public function getReviewsByRoom($roomId) {

        $parameters = [
            ':room_id' => $roomId,
        ];
        
        return $this->fetchAll('SELECT review.*, user.name as user_name FROM review INNER JOIN user ON review.user_id = user.user_id WHERE room_id = :room_id ORDER BY created_time DESC LIMIT 0,5' , $parameters);
    }

    public function paginationReviews($roomId) {

        $parameters = [
            ':room_id' => $roomId,
        ];
        
        $numberOfReviews = $this->fetch('SELECT COUNT(review_id) FROM review WHERE room_id = :room_id', $parameters);
        $results_per_page = 5;
        $number_of_pages = ceil($is_int/$results_per_page);

        if (!isset($_GET['page'])) {
            $page = 1;
          } else {
            $page = $_GET['page'];
          }
          $page_first_result = ($page-1)*$results_per_page;
          return $this->fetchAll("SELECT review.*, user.name as user_name FROM review INNER JOIN user ON review.user_id = user.user_id WHERE room_id = :room_id LIMIT " . $page_first_result . ',' . $results_per_page, $parameters);

    }

    public function countReviews($roomId) {

        $parameters = [
            ':room_id' => $roomId,
        ];
        return $this->fetch('SELECT COUNT(review_id) FROM review WHERE room_id = :room_id', $parameters);
   }
}