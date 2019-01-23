<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate user object
include_once '../objects/user_role.php';
 
$database = new Database();
$db = $database->getConnection();
 
$user_role = new User_Role($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->role_name) 
){
 
    // set role property values
    $user_role->role_name = $data->role_name;
 
    // create the role
    if($user_role->create()){
 
        // set response code - 201 created
        http_response_code(201);
        $RespCode = http_response_code(201);
 
        // tell the user
        echo json_encode(array("RespCode" => $RespCode,"exception" => "null", "RespMxg" => "success" , "RespObj" => "User Role Has Been Successfully Created", "RecordCount" => 0));
    }
 
    // if unable to create the role, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
        $RespCode = http_response_code(503);
 
        // tell the user
        echo json_encode(array("RespCode" => $RespCode,"exception" => "null", "RespMxg" => "failed" , "RespObj" => "Unable To Create User Role", "RecordCount" => 0));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
    $RespCode = http_response_code(400);
 
    // tell the user 
    echo json_encode(array("RespCode" => $RespCode,"exception" => "null", "RespMxg" => "failed" , "RespObj" => "Unable To Create User Role. Data Is Incomplete.", "RecordCount" => 0));
}
?>