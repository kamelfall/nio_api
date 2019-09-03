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
    include_once '../objects/order.php';

    // instantiate guest object
    include_once '../objects/guest.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    $order = new Order($db);
    $guest = new Guest($db);

    // get posted data
    $data = json_decode(file_get_contents("php://input"));
    
    // make sure data is not empty
    if(
        !empty($data->date) &&
        !empty($data->customer_id) &&
        !empty($data->time) &&
        !empty($data->seats)
    ){
    
      // set product property values
      $order->date = $data->date;
      $order->customer_id = $data->customer_id;
      $order->time = $data->time;
      $order->seats = $data->seats;

      $guest->first_name = $first_name->first_name;
      $guest->last_name = $last_name->last_name;
      $guest->email = $email->email;
      $guest->phone = $phone->phone;

    
      // create the product
      if($order->create() && $guest->createCustomer()){
  
          // set response code - 201 created
          http_response_code(201);
  
          // tell the user
          echo json_encode(array("message" => "Order was created."));
      }
  
      // if unable to create the product, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to create order."));
    }
}
  
  // tell the user data is incomplete
  else{
  
      // set response code - 400 bad request
      http_response_code(400);
  
      // tell the user
      echo json_encode(array("message" => "Unable to create order. Data is incomplete."));
  }
?>