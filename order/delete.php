<?php
  // required headers
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: DELETE");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
  // include database and object file
  include_once '../config/database.php';
  include_once '../objects/order.php';
  
  // get database connection
  $database = new Database();
  $db = $database->getConnection();
  
  // prepare product object
  $order = new Order($db);
  
  // get product id
  $data = $_GET["id"];
  
  // set product id to be deleted
  $order->id = $data;
  
  // delete the product
  if($order->delete()){
  
      // set response code - 200 ok
      http_response_code(200);
  
      // tell the user
      echo json_encode(array("message" => "Order was deleted."));
  }
  
  // if unable to delete the product
  else{
  
      // set response code - 503 service unavailable
      http_response_code(503);
  
      // tell the user
      echo json_encode(array("message" => "Unable to delete order."));
  }
?>