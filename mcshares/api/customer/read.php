<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/customer.php';
include_once '../token/validatetoken.php';
 
// instantiate database and customer object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$customer = new Customer($db);

$customer->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$customer->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

// query customer
$stmt = $customer->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // customer array
    $customer_arr=array();
    $customer_arr["pageno"]=$customer->pageNo;
	$customer_arr["pagesize"]=$customer->no_of_records_per_page;
    $customer_arr["total_count"]=$customer->total_record_count();
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
 
    // show customer data in json format
    echo json_encode(array("status" => "success", "code" => 1,"message"=> "customer found","document"=> $customer_arr));
}
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no customer found
    echo json_encode(array("status" => "error", "code" => 0,"message"=> "No customer found.","document"=> ""));
}