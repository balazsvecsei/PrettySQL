<?php

namespace Prettysql;

use \PDO;
use \Exception;

class Database implements DatabaseInterface
{
    private $connection;

    public function __construct($dbhost = "localhost", $dbname = "myDataBaseName", $username = "root", $password    = "")
    {
        try {

            $this->connection = new PDO("mysql:host=$dbhost;dbname=$dbname;", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function exec($query)
    {
        try {

            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
