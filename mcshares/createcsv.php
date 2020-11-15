<?php
    // show error reporting
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require 'class/dataBase.class.php';
    require 'class/addCustomer.class.php';

    // initialize object
    $database = new Database();
    $db = $database->getConnection();
    $addcustomer = new Addcustomer($db);

    // query customer
    $stmt = $addcustomer->read();
    $num = $stmt->rowCount();

    if($num>0){

        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="filename.csv"');
    
        $fh = fopen("php://output","w");

        $headers_item=array(
            "customer_id" => "customer_id",
            "contact_name" => "contact_name",
            "date_of_birth" => "date_of_birth",
            "customer_type" => "customer_type",
            "num_shares" => "num_shares",
            "share_price" => "share_price",
            "balance" => "balance",
        );
    
        fputcsv($fh,$headers_item);
 
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            
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
    
            fputcsv($fh,$customer_item);
        }

        fclose($fh);

    }
    else{
     
        // tell the user no products found
        echo json_encode(
            array("message" => "No products found.")
        );
    }





?>