<?php

  // required headers
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: POST");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  // get database connection
  include_once '../config/database.php';

  // instantiate product object
  include_once '../objects/guest.php';
  
  $database = new Database();
  $db = $database->getConnection();
  
  $guest = new Guest($db);
  
  // get posted data
  $data = json_decode(file_get_contents("php://input"));

  if(
    !empty($data->first_name) &&
    !empty($data->last_name) &&
    !empty($data->email) &&
    !empty($data->phone)

  ){

    $guest->first_name = $data->first_name;
    $guest->last_name = $data->last_name;
    $guest->email = $data->email;
    $guest->phone = $data->phone;
    
    if($guest->createCustomer()) {

      // set response code - 201 created
      http_response_code(201);
  
      // tell the user
      echo json_encode(array("message" => "Guest was created."));
    } 
    else {
  
      // set response code - 503 service unavailable
      http_response_code(503);

      // tell the user
      echo json_encode(array("message" => "Unable to create guest."));
    }
  }
?>
