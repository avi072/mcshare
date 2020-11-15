<?php

class Addcustomer {
    // database connection and table name
    private $conn;
    private $table_name = "customer";

    // object properties
    public $customer_id;
    public $customer_type;
    public $date_of_birth;
    public $date_incorp;
    public $registration_no;
    public $contact_name;
    public $num_shares;
    public $share_price;
    public $balance;
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function read(){
        // select all query
        $query = " 
                SELECT 
                customer.customer_id,
                contact_details.contact_name,
                customer.date_of_birth,
                customer.customer_type,
                shares_details.num_shares,
                shares_details.share_price,
                shares_details.balance
                FROM " . $this->table_name . " 
                LEFT JOIN contact_details 
                ON customer.customer_id = contact_details.customer_id 
                LEFT JOIN shares_details ON customer.customer_id = shares_details.customer_id
                ORDER BY customer.customer_id DESC
                ";
        
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();  
        
        return $stmt;

    }

    function insertcustomer(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                customer_id=:customer_id, customer_type=:customer_type, date_of_birth=:date_of_birth, date_incorp=:date_incorp,registration_no=:registration_no";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->customer_id=htmlspecialchars(strip_tags($this->customer_id));
        $this->customer_type=htmlspecialchars(strip_tags($this->customer_type));
        $this->date_of_birth=htmlspecialchars(strip_tags($this->date_of_birth));
        $this->date_incorp=htmlspecialchars(strip_tags($this->date_incorp));
        $this->registration_no=htmlspecialchars(strip_tags($this->registration_no));
        
        // bind values
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":customer_type", $this->customer_type);
        $stmt->bindParam(":date_of_birth", $this->date_of_birth);
        $stmt->bindParam(":date_incorp", $this->date_incorp);
        $stmt->bindParam(":registration_no", $this->registration_no);
    
        // execute query
        if($stmt->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
   
    }


}
?>