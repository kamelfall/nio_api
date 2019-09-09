<?php
  // required headers
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  
  // include database and object files
  include_once '../config/database.php';
  include_once '../objects/order.php';
  
  // instantiate database and product object
  $database = new Database();
  $db = $database->getConnection();
  
  // initialize object
  $guest = new Guest($db);

  
 function searchCustomer() {
   //select all data
   $query = "SELECT email FROM " . $this->table_name . "
   ORDER BY
     id";
 
   $stmt = $this->conn->prepare( $query );
   $stmt->execute();
 
   return $stmt;
   }



