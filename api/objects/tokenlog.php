<?php
class TokenLog{
 
    // database connection and table name
    private $conn;
    private $table_name = "tokenlog_tb";
 
    // object properties
    public $tokenlog_id;
    public $user_id;
    public $actiontime;
    public $location;
    public $token;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read tokenlog
    function read(){
        try
        {
 
    // select all query
    $query = "SELECT
                tokenlog_id, user_id, actiontime, location, token
            FROM
                " . $this->table_name . " ORDER BY tokenlog_id ASC";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();    
        }
        catch(PDOException $exception){
            echo "error: " . $exception->getMessage();
        }
        return $stmt;
    
}
// create tokenlog
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
            user_id=:user_id, actiontime=:actiontime, location=:location, token=:token";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->user_id=htmlspecialchars(strip_tags($this->user_id));
    $this->actiontime=htmlspecialchars(strip_tags($this->actiontime));
    $this->location=htmlspecialchars(strip_tags($this->location));
    $this->token=htmlspecialchars(strip_tags($this->token));
 
    // bind values
    $stmt->bindParam(":user_id", $this->user_id);
    $stmt->bindParam(":actiontime", $this->actiontime);
    $stmt->bindParam(":location", $this->location);
    $stmt->bindParam(":token", $this->token);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
// used when filling up the update role form
function read_by_id(){
 
    // query to read single record
    $query = "SELECT
            tokenlog_id, user_id, actiontime, location, token
            FROM
                " . $this->table_name . "
            WHERE
                tokenlog_id = ?
            LIMIT
                0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of customer to be updated
    $stmt->bindParam(1, $this->tokenlog_id);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->tokenlog_id = $row['tokenlog_id'];
    $this->user_id = $row['user_id'];
    $this->actiontime = $row['actiontime'];
    $this->location = $row['location'];
    $this->token = $row['token'];
}


function read_by_search_user(){
 
    // query to read single record
    $query = "SELECT
                role_id, role_name
            FROM
                " . $this->table_name . "
            WHERE
                role_name = ?
            LIMIT
                0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of customer to be updated
    $stmt->bindParam(1, $this->role_name);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->role_id = $row['role_id'];
    $this->role_name = $row['role_name'];
}
}
?>