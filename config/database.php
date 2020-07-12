<?php

class DatabaseClass
{
    private $host = "localhost";
    private $db_name = "api";
    private $username = "root";
    private $password = "";
    public $conn;

    //get the database  connection
    public function getConnection()
    {
        $this->conn = null;

        try
        {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=". $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn->exec("set names utf8");
        }
        catch(PDOException $e)
        {
            echo "Connection error: " . $e->getMessage();
        }
        return $this->conn;
    }
}

?>