<?php

class Addsharedetails {
    // database connection and table name
    private $conn;
    private $table_name = "shares_details";
  
    // object properties
    public $customer_id;
    public $num_shares;
    public $share_price;
    public $balance;
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

  

    function insertsharedetails(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                customer_id=:customer_id, num_shares=:num_shares, share_price=:share_price, balance=:balance";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->customer_id=htmlspecialchars(strip_tags($this->customer_id));
        $this->num_shares=htmlspecialchars(strip_tags($this->num_shares));
        $this->share_price=htmlspecialchars(strip_tags($this->share_price));
        $this->balance=htmlspecialchars(strip_tags($this->num_shares*$this->share_price));
        
        // bind values
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":num_shares", $this->num_shares);
        $stmt->bindParam(":share_price", $this->share_price);
        $stmt->bindParam(":balance", $this->balance);

    
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