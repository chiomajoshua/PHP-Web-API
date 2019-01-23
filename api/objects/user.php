<?php
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "user_tb";
 
    // object properties
    public $user_id;
    public $username;
    public $password;
    public $lastname;
    public $firstname;
    public $gender;
    public $phone;
    public $email;
    public $address;
    public $user_role;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function generateRandomString($length = 10) {
        $characters = '~!@#$^&*()_+{}|:"<>?0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    function login(){
        try
        {           
 
    // select all query
         $query = "SELECT
                        `user_id`, `username`, `password`, `lastname`, `firstname`, `gender`, `phone`, `email`, `address`, `user_role`
                    FROM
                        " . $this->table_name . " 
                    WHERE
                             username='".$this->username."' AND password='".$this->password."'";
    // prepare query statement
        $stmt = $this->conn->prepare($query);
    // execute query
        $stmt->execute();
    // return $stmt;
        }
        catch(PDOException $exception){
            echo "error: " . $exception->getMessage();
        }
        return $stmt;
    
}
 
 
// read all users registered

    function read(){
        try
        {
 
    // select all query
    $query = "SELECT
                user_id, username, lastname, firstname, gender, phone, email, address, user_role
            FROM
                " . $this->table_name . " ORDER BY user_id ASC";
 
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

   
// create user
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                username=:username, password=:password, lastname=:lastname, firstname=:firstname, gender=:gender, phone=:phone, email=:email, address=:address, 
                user_role=:user_role";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->username=htmlspecialchars(strip_tags($this->username));
    $this->password=htmlspecialchars(strip_tags($this->password));
    $this->lastname=htmlspecialchars(strip_tags($this->lastname));
    $this->firstname=htmlspecialchars(strip_tags($this->firstname));
    $this->gender=htmlspecialchars(strip_tags($this->gender));
    $this->phone=htmlspecialchars(strip_tags($this->phone));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->address=htmlspecialchars(strip_tags($this->address));    
    $this->user_role=htmlspecialchars(strip_tags($this->user_role));
 
    // bind values
    $stmt->bindParam(":username", $this->username);
    $stmt->bindParam(':password', $this->password);
    $stmt->bindParam(":lastname", $this->lastname);
    $stmt->bindParam(":firstname", $this->firstname);
    $stmt->bindParam(":gender", $this->gender);
    $stmt->bindParam(":phone", $this->phone);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":address", $this->address);
    $stmt->bindParam(":user_role", $this->user_role);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
// used when filling up the update user form
function read_by_id(){
 
    // query to read single record
    $query = "SELECT
                user_id, username, lastname, firstname, gender, phone, email, address, user_role
            FROM
                " . $this->table_name . " 
                WHERE
                    user_id = ?
                LIMIT
                   0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of user to be updated
    $stmt->bindParam(1, $this->sn);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->user_id = $row['user_id'];
    $this->username = $row['username'];
    $this->lastname = $row['lastname'];
    $this->firstname = $row['firstname'];
    $this->gender = $row['gender'];
    $this->phone = $row['phone'];
    $this->email = $row['email'];
    $this->address = $row['address'];
    $this->user_role = $row['user_role']; 
}

function update_password(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "                
        SET
            password=:password

            WHERE
                user_id = :user_id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
     // sanitize
     $this->password=htmlspecialchars(strip_tags($this->password));
 
    // bind new values
    $stmt->bindParam(":password", $this->password);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

// delete the customer
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE user_id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->user_id=htmlspecialchars(strip_tags($this->user_id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->user_id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
}
?>