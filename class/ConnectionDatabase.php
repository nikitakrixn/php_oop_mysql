<?php

/*
 * Connection Database Class
 */

class ConnectionDatabase extends Config
{

    /* The MYSQLI object */
    public $connect;

    /* constructor function, inits the database connection */
    public function __construct()
    {
        $this->connect();
    }

    /* connect function */
    public function connect()
    {
        $this->connect = new mysqli($this->host,$this->user,$this->pass,$this->dbName);

        if (!$this->connect) {
            echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
            echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
        $this->connect->query("SET NAMES 'utf8';");
        $this->connect->query("SET CHARACTER SET 'utf8';");
        $this->connect->query("SET SESSION collation_connection = 'utf8_general_ci';");
        return $this->connect;
    }

    /* getter function */
    public function getHost()
    {
        return $this->host;
    }

    public function getDbName()
    {
        return $this->dbName;
    }
    
    public function getUser()
    {
        return $this->user;
    }

    public function close()
    {
        return $this->connection->close();
    }

    public function lastInsertID()
    {
        return $this->connection->insert_id;
    }


}