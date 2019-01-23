<?php
class User_Role{
 
    // database connection and table name
    private $conn;
    private $table_name = "user_role_tb";
 
    // object properties
    public $role_id;
    public $role_name;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read user_roles
    function read(){
        try
        {
 
    // select all query
    $query = "SELECT
                role_id, role_name
            FROM
                " . $this->table_name . " ORDER BY role_id ASC";
 
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
// create roles
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                role_name=:role_name";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->role_name=htmlspecialchars(strip_tags($this->role_name));
 
    // bind values
    $stmt->bindParam(":role_name", $this->role_name);
 
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
                role_id, role_name
            FROM
                " . $this->table_name . "
            WHERE
                role_id = ?
            LIMIT
                0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of customer to be updated
    $stmt->bindParam(1, $this->role_id);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->role_id = $row['role_id'];
    $this->role_name = $row['role_name'];
}


function read_by_user_role(){
 
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

function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "

                
        SET
            role_name=:role_name,
            WHERE
                role_id = :role_id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
     // sanitize
     $this->role_name=htmlspecialchars(strip_tags($this->role_name));
     
     
    // bind new values
    $stmt->bindParam(":role_name", $this->role_name);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

// delete the user role
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE role_id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->role_id=htmlspecialchars(strip_tags($this->role_id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->role_id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
}
?>