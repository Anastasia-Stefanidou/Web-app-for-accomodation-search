<?php

namespace Hotel;

use PDO;
use support\configuration\configuration;

class BaseService {
    private static $pdo;

    public function __construct() {
        $this->initializePdo();
    }

    protected function initializePdo() {
        if (!empty(self::$pdo)) {
            return;
        }
        $config = configuration::getInstance();
        $databaseConfig = $config->getConfig()['database'];
        
        try {
        self::$pdo = new PDO(sprintf('mysql:host=%s;dbname=%s;charset=UTF8',  $databaseConfig['host'],  $databaseConfig['dbname']), $databaseConfig['username'],  $databaseConfig['password'],[PDO::
        MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"]);
        } catch (\PDOException $ex) {
            throw new \Exception(sprintf('Could not connect to database. Error: %s', $ex->getMessage()));
        }
    }

    // public function __construct() {
    //     $this->pdo = new PDO ('mysql:host=127.0.0.1;dbname=hotel;charset=UTF8', 'hotel', 'password', [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"]);
    // }

    // protected function initializePdo()
    // {
    //     //Check if pdo is already initialized
    //     if (!empty(self::$pdo)) {
    //         return;
    //     }
    //     $config = configuration::getInstance();
    //     $databaseConfig = $config->getConfig()['database'];
        
    //     //Connect to database
    //     self::$pdo = new PDO(sprintf('mysql:host=%s;dbname=%s;charset=UTF8',  $databaseConfig['host'],  $databaseConfig['dbname']), $databaseConfig['username'],  $databaseConfig['password'],[PDO::
    //     MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"]);
        
    // }

    protected function execute($sql, $parameters) {
        //Prepare statement
        $statement = $this->getPdo()->prepare($sql);
        $status = $statement->execute($parameters); 
        if (!$status) {
            throw new Exception($statement->errorInfo()[2]);
        }

        return $status;
    }
  
    protected function fetchAll($sql, $parameters = [], $type = PDO::FETCH_ASSOC) {
        //Prepare statement
        $statement = $this->getPdo()->prepare($sql);
        $status = $statement->execute($parameters);
        if (!$status) {
            throw new Exception($statement->errorInfo()[2]); 
        }
        //Fetch All
        return $statement->fetchAll($type);        
    }

    protected function fetch($sql, $parameters = [], $type = PDO::FETCH_ASSOC) {
        //Prepare statement
        $statement = $this->getPdo()->prepare($sql);
        $status = $statement->execute($parameters);
        if (!$status) {
            throw new Exception($statement->errorInfo()[2]); 
        }
        //Fetch All
        return $statement->fetch($type);                
    }

   protected function getPdo() {
        return self::$pdo;
    }
}