<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: access");
 
// include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/customer.php';
 
// instantiate database and product object
$database = new Database(); 
$db = $database->getConnection();
 
// initialize object
$customer = new Customer($db);
 
// get keywords
$keywords=isset($_GET["searchword"]) ? $_GET["searchword"] : "";
 
// query customer
$stmt = $customer->search($keywords);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // customer array
    $customer_arr=array();
    $customer_arr["RespObj"]=array();
 
    // retrieve our table contents
 
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
 
        array_push($customer_arr["RespObj"], $customer_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
    $RespCode = http_response_code(200);
 
    // show customer data
    echo json_encode(array("RespCode" => $RespCode,"exception" => "null", "RespMxg" => "success" , "RespObj" => $customer_arr, "RecordCount" => $num));;
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no customer found
    echo json_encode(
        array("message" => "No customer found.")
    );
}
?>