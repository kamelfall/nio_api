<?php
  class Guest{
  
    // database connection and table name
    private $conn;
    private $table_name = "guests";

    // object properties
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;

    public function __construct($db){
        $this->conn = $db;
    }

    // used by select drop-down list
    public function read(){
    
      //select all data
      $query = "SELECT
                  id, first_name, last_name, email, phone
              FROM
                  " . $this->table_name . "
              ORDER BY
                  id";

      $stmt = $this->conn->prepare( $query );
      $stmt->execute();

      return $stmt;
    }

    public function createCustomer() {
      $query = "INSERT INTO " . $this->table_name . 
      " SET first_name=:first_name, 
          last_name=:last_name, 
          email=:email, 
          phone=:phone";

      $stmt = $this->conn->prepare($query);
      //$stmt->execute();

      $this->first_name=htmlspecialchars(strip_tags($this->first_name));
      $this->last_name=htmlspecialchars(strip_tags($this->last_name));
      $this->email=htmlspecialchars(strip_tags($this->email));
      $this->phone=htmlspecialchars(strip_tags($this->phone));

      $stmt->bindParam(":first_name", $this->first_name);
      $stmt->bindParam(":last_name", $this->last_name);
      $stmt->bindParam(":email", $this->email);
      $stmt->bindParam(":phone", $this->phone);

      if($stmt->execute()){
        return true;
    }

    return false;
    }

    function search($keywords){

      // select all query
      $query = "SELECT o.id, o.date, o.customer_id, o.time, o.seats, 
                g.first_name, g.last_name, g.email, g.phone 
                FROM guests AS g INNER JOIN orders o 
                ON g.id = o.customer_id WHERE g.email = ?
                LIMIT 1";


      //$query = "SELECT * FROM guests";

      // prepare query statement
      $stmt = $this->conn->prepare($query);

      // sanitize
      $keywords=htmlspecialchars(strip_tags($keywords));
      //$keywords = "%{$keywords}%";

      // bind
      $stmt->bindParam(1, $keywords);

      // execute query
      $stmt->execute();

      return $stmt;

    }
  }
?>