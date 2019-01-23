<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/customer.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare customer object
$customer = new Customer($db);
 
// set ID property of record to read
$customer->customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : die();
 
// read the details of customer to be edited
$customer->read_by_customer_id();
 
if($customer->customer_id!=null){
    // create array
    $customer_arr = array(
        "sn" =>  $customer->sn,
        "customer_id" => $customer->customer_id,
        "lastname" => $customer->lastname,
        "firstname" => $customer->firstname,
        "phone" => $customer->phone,
        "email" => $customer->email,
        "address" =>  $customer->address,
        "gender" => $customer->gender,
        "preferred_product" => $customer->preferred_product,
        "favourite_club_country" => $customer->favourite_club_country,
        "facebook_handle" => $customer->facebook_handle,
        "instagram_handle" => $customer->instagram_handle
 
    );
 
    // set response code - 200 OK
    http_response_code(200);
    $RespCode = http_response_code(200);
 
        // make it json format
        echo json_encode(array("RespCode" => $RespCode,"exception" => "null", "RespMxg" => "success" , "RespObj" => $customer_arr, "RecordCount" => 1));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
    $RespCode = http_response_code(404);
    // tell the user customer does not exist
    echo json_encode(
    array("RespCode" => $RespCode,"RespMxg" => "Failed", "exception" => "null", "RespObj" => "No customers found.", "RecordCount" => 0)
    );
}
?>