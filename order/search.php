<?php
  // required headers
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: GET");
  
  // include database and object files
  include_once '../config/database.php';
  include_once '../objects/order.php';
  
  // instantiate database and order object
  $database = new Database();
  $db = $database->getConnection();
  
  // initialize object
  $order = new Order($db);
  
  // get keywords
  $keywords=isset($_GET["s"]) ? $_GET["s"] : "";
  
  // query orders
  $stmt = $order->search($keywords);
  $num = $stmt->rowCount();
  
  // check if more than 0 record found
  if($num>0){
  
      // orders array
      $orders_arr=array();
      $orders_arr["records"]=array();
  
      // retrieve our table contents
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          // extract row
          // this will make $row['name'] to
          // just $name only
          extract($row);
  
          $order_item=array(
              "order_id" => $id,
              "date" => $date,
              "customer_id" => $customer_id,
              "time" => $time,
              "seats" => $seats,
              "first_name" => $first_name,
              "last_name" => $last_name,
              "email" => $email,
              "phone" => $phone
          );
  
          array_push($orders_arr["records"], $order_item);
      }
  
      // set response code - 200 OK
      http_response_code(200);
  
      // show orders data
      echo json_encode($orders_arr);
  }
  
  else{
      // set response code - 404 Not found
      http_response_code(404);
  
      // tell the user no products found
      echo json_encode(
          array("message" => "No products found.")
      );
  }
?>