<?php

class Addmailaddres {
    // database connection and table name
    private $conn;
    private $table_name = "mailing_address";
  
    // object properties
    public $customer_id;
    public $address_line1;
    public $address_line2;
    public $town_city;
    public $country;
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function insertmailaddres(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                customer_id=:customer_id, address_line1=:address_line1, address_line2=:address_line2, town_city=:town_city, country=:country";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->customer_id=htmlspecialchars(strip_tags($this->customer_id));
        $this->address_line1=htmlspecialchars(strip_tags($this->address_line1));
        $this->address_line2=htmlspecialchars(strip_tags($this->address_line2));
        $this->town_city=htmlspecialchars(strip_tags($this->town_city));
        $this->country=htmlspecialchars(strip_tags($this->country));
        
        // bind values
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":address_line1", $this->address_line1);
        $stmt->bindParam(":address_line2", $this->address_line2);
        $stmt->bindParam(":town_city", $this->town_city);
        $stmt->bindParam(":country", $this->country);

    
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