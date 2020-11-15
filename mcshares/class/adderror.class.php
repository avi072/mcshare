<?php

class Adderror {
    // database connection and table name
    private $conn;
    private $table_name = "log_error";
  
    // object properties
    public $message;
    public $error_code;
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function inserterror(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                message=:message, error_code=:error_code";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->message=htmlspecialchars(strip_tags($this->message));
        $this->error_code=htmlspecialchars(strip_tags($this->error_code));
        
        // bind values
        $stmt->bindParam(":message", $this->message);
        $stmt->bindParam(":error_code", $this->error_code);
        
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

    function errormessage($message){
        echo '<div class="alert alert-danger mt-2" role="alert">';
            echo $message;
        echo '</div>';
    }

    function successmessage($message){
        echo '<div class="alert alert-success mt-2" role="alert">';
            echo $message;
        echo '</div>';
    }
}
?>