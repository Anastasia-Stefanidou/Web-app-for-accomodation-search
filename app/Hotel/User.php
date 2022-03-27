<?php

namespace Hotel;

use PDO;
use Hotel\BaseService;
use support\configuration\configuration;

class User extends BaseService {
    const TOKEN_KEY = 'asfdhkgjlr;ofijhgbfdklfsadf';

    private static $currentUserId;

    public function getByEmail($email) {
        $parameters = [
            ':email' => $email,
        ];
        return $this->fetch('SELECT * FROM USER WHERE email = :email', $parameters);
    }

    public function getByName($name) {
        $parameters = [
            ':name' => $name,
        ];
        return $this->fetch('SELECT * FROM USER WHERE name = :name', $parameters);
    }

    public function getByUserId($userId) {
        $parameters = [
        ':user_id' => $userId,
        ];
        return $this->fetch('SELECT * FROM user WHERE user_id = :user_id', $parameters);
    }

    public function getList() {
        return $this->fetchAll('SELECT * FROM user');
    }

    public function insert($name, $email, $password) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $parameters = [
            ':name' => $name,
            ':email' => $email,
            ':password' => $passwordHash,
        ];
        
        $rows = $this->execute('INSERT INTO user (name, email, password) VALUES 
        (:name, :email, :password)', $parameters);

         return $rows == 1;
    }

    public function verify($email, $password) {
        // Step 1 - Retrieve user
        $user = $this->getByEmail($email);

        // Step 2 - Verify user password
        return password_verify($password, $user['password']);
    }

    public function verifyUser($name, $password) {
        // Step 1 - Retrieve user
        $user = $this->getByName($name);

        // Step 2 - Verify user password
        $rows = password_verify($password, $user['password']);
        return $rows;
    }

    public function generateToken($userId) {
        $payload = [
            'user_id' => $userId,
        ];
        $payloadEncoded = base64_encode(json_encode($payload));
        $signature = hash_hmac('sha256', $payloadEncoded, self::TOKEN_KEY);

        return sprintf('%s.%s', $payloadEncoded, $signature);
    }

    public function getTokenPayload($token) {
        [$payloadEncoded] = explode('.', $token);

        return json_decode(base64_decode($payloadEncoded), true);
    }

    public function verifyToken($token) {
        $payload = $this->getTokenPayload($token);
        // $payload = getTokenPayload($token);
        $userId = $payload['user_id'];
        // $csrf = $payload['csrf'];

        return $this->generateToken($userId) == $token;
    }

    // public static function verifyCsrf($csrf)
    // {
    //     return self::getCsrf() == $csrf;
    // }

    // public static function getCsrf()
    // {
    //     $token = $_COOKIE['user_token']; 
    //     $payload = $this->getTokenPayload($token);
        
    //     return $payload['csrf'];
    
    // }

    public static function getCurrentUserId() {
        return self::$currentUserId;
    }

    public static function setCurrentUserId($userId) {
        self::$currentUserId = $userId;
    }
}