<?php
  class Order{
  
    // database connection and table name
    private $conn;
    private $table_name = "orders";

    // object properties
    public $id;
    public $date;
    public $customer_id;
    public $time;
    public $seats;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read all orders
    function readAll() {
      $query = "SELECT o.id, o.date, o.customer_id, o.time, o.seats, 
                g.first_name, g.last_name, g.email, g.phone 
                FROM orders AS o INNER JOIN guests g 
                ON o.customer_id = g.id ORDER BY o.date ASC";
                

      $stmt = $this->conn->prepare($query);

      $stmt->execute();

      return $stmt;
    }

    // create order
    function create(){
    
      // query to insert record
      $query = "INSERT INTO
                  " . $this->table_name . "
              SET
                  date=:date, customer_id=:customer_id, time=:time, seats=:seats";

      // prepare query
      $stmt = $this->conn->prepare($query);

      // sanitize
      $this->date=htmlspecialchars(strip_tags($this->date));
      $this->customer_id=htmlspecialchars(strip_tags($this->customer_id));
      $this->time=htmlspecialchars(strip_tags($this->time));
      $this->seats=htmlspecialchars(strip_tags($this->seats));

      // bind values
      $stmt->bindParam(":date", $this->date);
      $stmt->bindParam(":customer_id", $this->customer_id);
      $stmt->bindParam(":time", $this->time);
      $stmt->bindParam(":seats", $this->seats);

      // execute query
      if($stmt->execute()){
          return true;
      }

      return false;
      
    }

    // update the order
    function update(){
    
      // update query
      $query = "UPDATE
                  " . $this->table_name . "
              SET
                  seats = :seats
              WHERE
                  id = :id";

      // prepare query statement
      $stmt = $this->conn->prepare($query);

      // sanitize
      $this->seats=htmlspecialchars(strip_tags($this->seats));
      $this->id=htmlspecialchars(strip_tags($this->id));

      // bind new values
      $stmt->bindParam(':seats', $this->seats);
      $stmt->bindParam(':id', $this->id);

      // execute the query
      if($stmt->execute()){
          return true;
      }

      return false;
    }

    // delete the order
    function delete(){
    
      // delete query
      $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

      // prepare query
      $stmt = $this->conn->prepare($query);

      // sanitize
      $this->id=htmlspecialchars(strip_tags($this->id));

      // bind id of record to delete
      $stmt->bindParam(1, $this->id);

      // execute query
      if($stmt->execute()){
          return true;
      }

      return false;
      
    }


    // search orders
    function search($keywords){
    
      // select all query
      $query = "SELECT o.id, o.date, o.customer_id, o.time, o.seats, 
                g.first_name, g.last_name, g.email, g.phone 
                FROM orders AS o INNER JOIN guests g 
                ON o.customer_id = g.id WHERE g.last_name LIKE ? OR o.id LIKE ? 
                ORDER BY o.date ASC";

      // prepare query statement
      $stmt = $this->conn->prepare($query);

      // sanitize
      $keywords=htmlspecialchars(strip_tags($keywords));
      $keywords = "%{$keywords}%";

      // bind
      $stmt->bindParam(1, $keywords);
      $stmt->bindParam(2, $keywords);

      // execute query
      $stmt->execute();

      return $stmt;
    }

  }