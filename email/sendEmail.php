<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
    
    // make sure data is not empty
    if(
        !empty($data->date) &&
        !empty($data->email) &&
        !empty($data->time) &&
        !empty($data->seats) &&
        !empty($data->first_name) &&
        !empty($data->last_name)
    ){
        $guestQuantity = "guests";
        if($data->seats < 2){
            $guestQuantity = "guest";
        }
        $message = "Hello " . $data->first_name . " " . $data->last_name . 
            "! You have booked a table for " . $data->seats . " " . $guestQuantity . 
            " on " . $data->date . " at " . $data->time . ". See you there!";
        $message = wordwrap($message,70);
        $headers = 'From: nio@gmail.com' . "\r\n" .
        'Reply-To: nio@gmail.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
        mail($data->email, "Your booking confirmation", $message, $headers);
    } else {
        echo json_encode(array("message" => "Unable to send email. Data is incomplete."));
    }
?>