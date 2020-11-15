<?php

class AddXmlDetails {
    // database connection and table name
    private $conn;
    private $table_name = "xml_details";
  
    // object properties
    public $doc_date;
    public $doc_ref;
    public $doc_name;
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function insertxmldetails(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                doc_date=:doc_date, doc_ref=:doc_ref, doc_name=:doc_name";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->doc_name=htmlspecialchars(strip_tags($this->doc_name));
        $this->doc_date=htmlspecialchars(strip_tags($this->doc_date));
        $this->doc_ref=htmlspecialchars(strip_tags($this->doc_ref));
    
        // bind values
        $stmt->bindParam(":doc_name", $this->doc_name);
        $stmt->bindParam(":doc_date", $this->doc_date);
        $stmt->bindParam(":doc_ref", $this->doc_ref);
    
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