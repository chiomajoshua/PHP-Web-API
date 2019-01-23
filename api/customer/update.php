<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/customer.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare customer object
$customer = new Customer($db);
 
// get id of customer to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of customer to be edited
$customer->sn = $data->sn;
 
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
 
// update the customer
if($customer->update()){
 
    // set response code - 200 ok
    http_response_code(200);
    $RespCode = http_response_code(200);
 
    // tell the user
    echo json_encode(array("RespCode" => $RespCode,"exception" => "null", "RespMxg" => "success" , "RespObj" => "Customer Account Has Been Successfully Updated", "RecordCount" => 0));
}
 
// if unable to update the customer, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
    $RespCode = http_response_code(503);
 
    // tell the user
    echo json_encode(array("RespCode" => $RespCode,"exception" => "null", "RespMxg" => "failed" , "RespObj" => "Unable To Update Customer Account", "RecordCount" => 0));
}
?>