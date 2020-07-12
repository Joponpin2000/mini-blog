<?php

class Post
{
    // database connection and table name
    private $conn;
    private $table_name = "posts";

    // object properties
    public $id;
    public $title;
    public $body;
    public $category_id;
    public $category_name;
    public $created_at;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read posts
    function read()
    {
        //select all query
        $query = "SELECT c.name as category_name, p.id, p.title, p.body, p.category_id, p.created_at
                    FROM " . $this->table_name . " p LEFT JOIN categories c ON p.category_id = c.id
                    ORDER BY p.created_at DESC";
        
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // used when filling up the update post form
    function readOne()
    {
        // query to read single record
        $query = "SELECT c.name as category_name, p.id, p.title, p.body, p.category_id, p.created_at
                    FROM " . $this->table_name . " p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ? LIMIT 0,1";
        
            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // bind id of post to be updated
            $stmt->bindParam(1, $this->id);


            // execute query
            $stmt->execute();

            // get retrieved row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // set values to object properties
            $this->title = $row['title'];
            $this->body = $row['body'];
            $this->category_id = $row['category_id'];
            $this->category_name = $row['category_name'];
    }

    // create post
    function create()
    {
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET title=:title, body=:body, category_id=:category_id, created_at=:created_at";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->name = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->created_at = htmlspecialchars(strip_tags($this->created_at));

        // bind values
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":body", $this->body);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":created_at", $this->created_at);

        // execute query
        if ($stmt->execute())
        {
            return true;
        }
        printf("Error %s. \n", $stmt->error);
        return false;
    }

    // update the post
    function update()
    {
        // update query
        $query = "UPDATE " . $this->table_name . " SET title=:title, body=:body, category_id=:category_id WHERE id=:id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind new values
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":body", $this->body);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":id", $this->id);
        
        // execute the query
        if ($stmt->execute())
        {
            return true;
        }
        else
        {
            printf("Error %s. \n", $stmt->error);
            return false;
        }
    }

    // delete the post
    function delete(){
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        //prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind id of record to delete
        $stmt->bindParam(1, $this->id);

        // execute query
        if ($stmt->execute())
        {
            return true;
        }
        printf("Error %s. \n", $stmt->error);
        return false;
    }

    // search posts
    function search($keywords)
    {
        //select all query
        $query = "SELECT c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                    FROM " . $this->table_name . " p LEFT JOIN categories c ON p.category_id = c.id WHERE p.name LIKE ? OR p.description LIKE ? OR 
                    c.name LIKE ? ORDER BY p.created DESC";
        
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $keywords = htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";

        // bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);


        // execute query
        $stmt->execute();

        return $stmt;
    }

    // read posts with pagination
    public function readPaging($from_record_num, $records_per_page )
    {
       // select query
       $query = "SELECT c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
       FROM " . $this->table_name . " p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created DESC LIMIT ?, ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);


        // execute query
        $stmt->execute();

        return $stmt;
    }

    // used for paging posts
    public function count()
    {
        $query = "SELECT COUNT(*) as total_rows from " . $this->table_name . "";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }
}
?>