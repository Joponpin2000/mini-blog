<?php
class Category
{
    // database connection and table name
    private $conn;
    private $table_name = "categories";

    // categoryy properties
    public $id;
    public $name;
    public $created_at;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // used by select drop-down list
    public function read()
    {
        //select all data
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY name";
        
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
}

?>