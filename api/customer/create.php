<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/customer.php';
 
$database = new Database();
$db = $database->getConnection();
 
$customer = new Customer($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->customer_id) &&
    !empty($data->lastname) &&
    !empty($data->firstname) &&
    !empty($data->phone) &&
    !empty($data->email) &&
    !empty($data->address) &&
    !empty($data->gender) &&
    !empty($data->preferred_product) &&
    !empty($data->favourite_club_country) &&
    !empty($data->facebook_handle) &&
    !empty($data->instagram_handle)
){
 
    // set customer property values
    $customer->customer_id = $data->customer_id;
    $customer->lastname = $data->lastname;
    $customer->firstname = $data->firstname;
    $customer->phone = $data->phone;
    $customer->email = $data->email;
    $customer->address = $data->address;
    $customer->gender = $data->gender;
    $customer->preferred_product = $data->preferred_product;
    $customer->favourite_club_country = $data->favourite_club_country;
    $customer->facebook_handle = $data->facebook_handle;
    $customer->instagram_handle = $data->instagram_handle;
 
    // create the customer
    if($customer->create()){
 
        // set response code - 201 created
        http_response_code(201);
        $RespCode = http_response_code(201);
 
        // tell the user
        echo json_encode(array("RespCode" => $RespCode,"exception" => "null", "RespMxg" => "success" , "RespObj" => "Customer Account Has Been Successfully Created", "RecordCount" => 0));
    }
 
    // if unable to create the customer, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
        $RespCode = http_response_code(503);
 
        // tell the user
        echo json_encode(array("RespCode" => $RespCode,"exception" => "null", "RespMxg" => "failed" , "RespObj" => "Unable To Create Customer Account", "RecordCount" => 0));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
    $RespCode = http_response_code(400);
 
    // tell the user 
    echo json_encode(array("RespCode" => $RespCode,"exception" => "null", "RespMxg" => "failed" , "RespObj" => "Unable To Create Customer Account. Data Is Incomplete.", "RecordCount" => 0));
}
?>