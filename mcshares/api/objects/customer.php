<?php
class Customer{
 
    // database connection and table name
    private $conn;
    private $table_read = "customer";
    private $table_update = "shares_details";
    private $table_search = "contact_details";

    public $pageNo = 1;
	public  $no_of_records_per_page=30;

    // customer properties
    public $customer_id;
    public $contact_name;
    public $date_of_birth;
    public $customer_type;
    public $num_shares;
    public $share_price;
    public $balance;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function total_record_count() {
        $query = "select count(1) as total from ". $this->table_read ."";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    function checkifcorporate()
    {
        // select all query
        $query = " 
                SELECT 
                *
                FROM " . $this->table_read . " 
                WHERE
                customer_type = 'Corporate'
                AND 
                customer_id = :customer_id
                ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->customer_id=htmlspecialchars(strip_tags($this->customer_id));
        
        // bind new values
        $stmt->bindParam(':customer_id', $this->customer_id);

         // execute the query
        $stmt->execute();

        return $stmt;
        
    }

    // read customer
    function read(){

        if(isset($_GET["pageNo"])){
            $this->pageNo=$_GET["pageNo"];
        }
        $offset = ($this->pageNo-1) * $this->no_of_records_per_page;
    
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
                FROM " . $this->table_read . " 
                LEFT JOIN contact_details 
                ON customer.customer_id = contact_details.customer_id 
                LEFT JOIN shares_details ON customer.customer_id = shares_details.customer_id
               
                ORDER BY customer.customer_id DESC 
                LIMIT " .$offset ." , ".$this->no_of_records_per_page."
                ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // update the sharesdetails
    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_update . "
                SET
                    num_shares = :num_shares,
                    share_price = :share_price,
                    balance = :balance
                WHERE
                    customer_id = :customer_id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->customer_id=htmlspecialchars(strip_tags($this->customer_id));
        $this->num_shares=htmlspecialchars(strip_tags($this->num_shares));
        $this->share_price=htmlspecialchars(strip_tags($this->share_price));
        $this->balance=htmlspecialchars(strip_tags($this->balance));

        // bind new values
        $stmt->bindParam(':customer_id', $this->customer_id);
        $stmt->bindParam(':num_shares', $this->num_shares);
        $stmt->bindParam(':share_price', $this->share_price);
        $stmt->bindParam(':balance', $this->balance);

    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // search products
    function search($keywords){
 
        // select all query

        $query = " 
                SELECT 
                contact_details.contact_name,
                customer.customer_id,
                customer.date_of_birth,
                customer.customer_type,
                shares_details.num_shares,
                shares_details.share_price,
                shares_details.balance
                FROM " . $this->table_search . " 
                LEFT JOIN customer 
                ON contact_details.customer_id = customer.customer_id 
                LEFT JOIN shares_details ON contact_details.customer_id = shares_details.customer_id
                WHERE contact_details.contact_name LIKE ?
                ORDER BY customer.customer_id DESC
                ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
    
        // bind
        $stmt->bindParam(1, $keywords);

    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }



    
}
?>