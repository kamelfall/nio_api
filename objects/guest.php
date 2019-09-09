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
  }
?>