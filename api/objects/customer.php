<?php
class Customer{
 
    // database connection and table name
    private $conn;
    private $table_name = "customer_tb";
 
    // object properties
    public $sn;
    public $customer_id;
    public $lastname;
    public $firstname;
    public $phone;
    public $email;
    public $address;
    public $gender;
    public $preferred_product;
    public $favourite_club_country;
    public $facebook_handle;
    public $instagram_handle;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read customers
    function read(){
        try
        {
 
    // select all query
    $query = "SELECT
                sn, customer_id, lastname, firstname, phone, email, address, gender, preferred_product, favourite_club_country, facebook_handle, instagram_handle
            FROM
                " . $this->table_name . " ORDER BY sn ASC";
 
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

function isAlreadyExist(){
    $query = "SELECT *
        FROM
            " . $this->table_name . " 
        WHERE
            customer_id='".$this->customer_id."'";
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    if($stmt->rowCount() > 0){
        return true;
    }
    else{
        return false;
    }
}
// create customer
function create(){
    
    if($this->isAlreadyExist()){
        return false;
    }
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                customer_id=:customer_id, lastname=:lastname, firstname=:firstname, phone=:phone, email=:email, address=:address, gender=:gender, 
                preferred_product=:preferred_product, favourite_club_country=:favourite_club_country, facebook_handle=:facebook_handle, 
                instagram_handle=:instagram_handle";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->customer_id=htmlspecialchars(strip_tags($this->customer_id));
    $this->lastname=htmlspecialchars(strip_tags($this->lastname));
    $this->firstname=htmlspecialchars(strip_tags($this->firstname));
    $this->phone=htmlspecialchars(strip_tags($this->phone));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->address=htmlspecialchars(strip_tags($this->address));
    $this->gender=htmlspecialchars(strip_tags($this->gender));
    $this->preferred_product=htmlspecialchars(strip_tags($this->preferred_product));
    $this->favourite_club_country=htmlspecialchars(strip_tags($this->favourite_club_country));
    $this->facebook_handle=htmlspecialchars(strip_tags($this->facebook_handle));
    $this->instagram_handle=htmlspecialchars(strip_tags($this->instagram_handle));
 
    // bind values
    $stmt->bindParam(":customer_id", $this->customer_id);
    $stmt->bindParam(":lastname", $this->lastname);
    $stmt->bindParam(":firstname", $this->firstname);
    $stmt->bindParam(":phone", $this->phone);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":address", $this->address);
    $stmt->bindParam(":gender", $this->gender);
    $stmt->bindParam(":preferred_product", $this->preferred_product);
    $stmt->bindParam(":favourite_club_country", $this->favourite_club_country);
    $stmt->bindParam(":facebook_handle", $this->facebook_handle);
    $stmt->bindParam(":instagram_handle", $this->instagram_handle);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
// used when filling up the update customer form
function read_by_id(){
 
    // query to read single record
    $query = "SELECT
                sn, customer_id, lastname, firstname, phone, email, address, gender, preferred_product, favourite_club_country, facebook_handle, instagram_handle
            FROM
                " . $this->table_name . "
            WHERE
                sn = ?
            LIMIT
                0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of customer to be updated
    $stmt->bindParam(1, $this->sn);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->customer_id = $row['customer_id'];
    $this->lastname = $row['lastname'];
    $this->firstname = $row['firstname'];
    $this->phone = $row['phone'];
    $this->email = $row['email'];
    $this->address = $row['address'];
    $this->gender = $row['gender'];
    $this->preferred_product = $row['preferred_product'];
    $this->favourite_club_country = $row['favourite_club_country'];
    $this->facebook_handle = $row['facebook_handle'];
    $this->instagram_handle = $row['instagram_handle'];
}
function read_by_customer_id(){
 
    // query to read single record
    $query = "SELECT
                sn, customer_id, lastname, firstname, phone, email, address, gender, preferred_product, favourite_club_country, facebook_handle, instagram_handle
            FROM
                " . $this->table_name . "
            WHERE
                customer_id = ?
            LIMIT
                0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of customer to be updated
    $stmt->bindParam(1, $this->customer_id);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->sn = $row['sn'];
    $this->customer_id = $row['customer_id'];
    $this->lastname = $row['lastname'];
    $this->firstname = $row['firstname'];
    $this->phone = $row['phone'];
    $this->email = $row['email'];
    $this->address = $row['address'];
    $this->gender = $row['gender'];
    $this->preferred_product = $row['preferred_product'];
    $this->favourite_club_country = $row['favourite_club_country'];
    $this->facebook_handle = $row['facebook_handle'];
    $this->instagram_handle = $row['instagram_handle'];
}

function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "

                
        SET
            customer_id=:customer_id, 
            lastname=:lastname, 
            firstname=:firstname, 
            phone=:phone, 
            email=:email, 
            address=:address, 
            gender=:gender, 
            preferred_product=:preferred_product, 
            favourite_club_country=:favourite_club_country, 
            facebook_handle=:facebook_handle, 
            instagram_handle=:instagram_handle
            WHERE
                sn = :sn";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
     // sanitize
     $this->customer_id=htmlspecialchars(strip_tags($this->customer_id));
     $this->lastname=htmlspecialchars(strip_tags($this->lastname));
     $this->firstname=htmlspecialchars(strip_tags($this->firstname));
     $this->phone=htmlspecialchars(strip_tags($this->phone));
     $this->email=htmlspecialchars(strip_tags($this->email));
     $this->address=htmlspecialchars(strip_tags($this->address));
     $this->gender=htmlspecialchars(strip_tags($this->gender));
     $this->preferred_product=htmlspecialchars(strip_tags($this->preferred_product));
     $this->favourite_club_country=htmlspecialchars(strip_tags($this->favourite_club_country));
     $this->facebook_handle=htmlspecialchars(strip_tags($this->facebook_handle));
     $this->instagram_handle=htmlspecialchars(strip_tags($this->instagram_handle));
 
    // bind new values
    $stmt->bindParam(":customer_id", $this->customer_id);
    $stmt->bindParam(":lastname", $this->lastname);
    $stmt->bindParam(":firstname", $this->firstname);
    $stmt->bindParam(":phone", $this->phone);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":address", $this->address);
    $stmt->bindParam(":gender", $this->gender);
    $stmt->bindParam(":preferred_product", $this->preferred_product);
    $stmt->bindParam(":favourite_club_country", $this->favourite_club_country);
    $stmt->bindParam(":facebook_handle", $this->facebook_handle);
    $stmt->bindParam(":instagram_handle", $this->instagram_handle);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

// delete the customer
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE sn = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->sn=htmlspecialchars(strip_tags($this->sn));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->sn);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

// search customers
function search($keywords){
 
    // select all query
    $query = "SELECT
                sn, customer_id, lastname, firstname, phone, email, address, gender, preferred_product, favourite_club_country, facebook_handle, instagram_handle
            FROM
                " . $this->table_name . "
               
            WHERE
                customer_id LIKE ? OR lastname LIKE ? OR firstname LIKE ? OR
                phone LIKE ?
            ORDER BY
                sn DESC";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";
 
    // bind
    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);
    $stmt->bindParam(3, $keywords);
    $stmt->bindParam(4, $keywords);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}
}
?>