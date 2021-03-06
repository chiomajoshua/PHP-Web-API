<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object file
include_once '../config/database.php';
include_once '../objects/customer.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare customer object
$customer = new Customer($db);
 
// get customer id
$data = json_decode(file_get_contents("php://input"));
 
// set customer id to be deleted
$customer->sn = $data->sn;
 
// delete the customer
if($customer->delete()){
 
    // set response code - 200 ok
    http_response_code(200); $RespCode = http_response_code(200);
 
    // tell the user
    echo json_encode(array("RespCode" => $RespCode,"exception" => "null", "RespMxg" => "success" , "RespObj" => "Customer Account Has Been Successfully Deleted", "RecordCount" => 0));
}
 
// if unable to delete the customer
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
    $RespCode = http_response_code(503);
 
    // tell the user
    echo json_encode(array("RespCode" => $RespCode,"exception" => "null", "RespMxg" => "failed" , "RespObj" => "Unable To Delete Customer Account", "RecordCount" => 0));
}
?>