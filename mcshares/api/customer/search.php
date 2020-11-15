<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/customer.php';
include_once '../token/validatetoken.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$customer = new customer($db);
 
// get keywords
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";

// query customer
$stmt = $customer->search($keywords);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // customer array
    $customer_arr=array();
    $customer_arr["records"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $customer_item=array(
            "customer_id" => $customer_id,
            "contact_name" => $contact_name,
            "date_of_birth" => $date_of_birth,
            "customer_type" => $customer_type,
            "num_shares" => $num_shares,
            "share_price" => $share_price,
            "balance" => $balance,
        );
 
        array_push($customer_arr["records"], $customer_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show customer data
    echo json_encode($customer_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no customer found
    echo json_encode(
        array("message" => "No contact found.")
    );
}
?>