<?php
  // required headers
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: GET");
  header("Content-Type: application/json; charset=UTF-8");
  
  // include database and object files
  include_once '../config/database.php';
  include_once '../objects/guest.php';
  
  // instantiate database and product object
  $database = new Database();
  $db = $database->getConnection();
  
  // initialize object
  $guest = new Guest($db);
  
  // get keywords
  $keywords=isset($_GET["s"]) ? $_GET["s"] : "";
  
  // query products
  $stmt = $guest->search($keywords);
  $num = $stmt->rowCount();
  
  // check if more than 0 record found
  if($num>0){
  
      // products array
      $guests_arr=array();
      $guests_arr["records"]=array();
  
      // retrieve our table contents
      // fetch() is faster than fetchAll()
      // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          // extract row
          // this will make $row['name'] to
          // just $name only
          extract($row);
  
          $guest_item=array(
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
  
          array_push($guests_arr["records"], $guest_item);
      }
  
      // set response code - 200 OK
      http_response_code(200);
  
      // show products data
      echo json_encode($guests_arr);
  }
  
  else{
      // set response code - 404 Not found
      http_response_code(404);
  
      // tell the user no products found
      echo json_encode(
          array("message" => "No guests found.")
      );
  }
?>