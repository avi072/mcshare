<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/customer.php';
include_once '../token/validatetoken.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$customer = new Customer($db);
 
// get id of customer to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of customer to be edited
$customer->customer_id = $data->customer_id;
 
// set customer property values
$customer->num_shares = $data->num_shares;
$customer->share_price = $data->share_price;
$customer->balance = $customer->num_shares*$customer->share_price;


$stmt = $customer->checkifcorporate();
$num = $stmt->rowCount();

if($num==0){

    // update the customer
    if($customer->update()){
    
        // set response code - 200 ok
        http_response_code(200);
    
        // tell the user
        echo json_encode(array("message" => "customer was updated."));
    }
    
    // if unable to update the customer, tell the user
    else
    {
    
        // set response code - 503 service unavailable
        http_response_code(503);
    
        // tell the user
        echo json_encode(array("message" => "Unable to update customer."));
    }

}
else
{
    // set response code - 503 service unavailable
    http_response_code(503);
    
    // tell the user
    echo json_encode(array("message" => "Unable to update customer (corporate) ."));
}
 

?>