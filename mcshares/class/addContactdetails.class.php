<?php

class Addcontactdetails {
    // database connection and table name
    private $conn;
    private $table_name = "contact_details";
  
    // object properties
    public $customer_id;
    public $contact_name;
    public $contact_number;
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function insertcontactdetails(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                customer_id=:customer_id, contact_name=:contact_name, contact_number=:contact_number";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->customer_id=htmlspecialchars(strip_tags($this->customer_id));
        $this->contact_name=htmlspecialchars(strip_tags($this->contact_name));
        $this->contact_number=htmlspecialchars(strip_tags($this->contact_number));
        
        // bind values
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":contact_name", $this->contact_name);
        $stmt->bindParam(":contact_number", $this->contact_number);

    
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