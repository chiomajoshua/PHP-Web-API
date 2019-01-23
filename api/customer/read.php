<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/customer.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$customer = new Customer($db);
 
// read customer will be here
// query products
$stmt = $customer->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $customers_arr=array();
    $customers_arr["RespObj"]=array();
    $RespCode = http_response_code(200);
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $customer_item=array(
            "sn" => $sn,
            "customer_id" => $customer_id,
            "lastname" => $lastname,
            "firstname" => $firstname,
            "phone" => $phone,
            "email" => $email,
            "address" => $address,
            "gender" => $gender,
            "preferred_product" => $preferred_product,
            "favourite_club_country" => $favourite_club_country,
            "facebook_handle" => $facebook_handle,
            "instagram_handle" => $instagram_handle
        );
 
        array_push($customers_arr["RespObj"], $customer_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show customer data in json format
    echo json_encode(array("RespCode" => $RespCode,"exception" => "null", "RespMxg" => "success" , $customers_arr, "RecordCount" => $num));
}


 
// no customer found will be here
else{
 
    // set response code - 404 Not found
    http_response_code(404);
    $RespCode = http_response_code(404);
 
    // tell the user no customer found
    echo json_encode(
        array("RespCode" => $RespCode,"RespMxg" => "Failed", "exception" => "null", "RespObj" => "No customers found.", "RecordCount" => $num)
    );
}

?>