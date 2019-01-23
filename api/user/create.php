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
include_once '../objects/user.php';
 
$database = new Database();
$db = $database->getConnection();
 
$user = new User($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->username) &&
    !empty($data->password) &&
    !empty($data->lastname) &&
    !empty($data->firstname) &&
    !empty($data->gender) &&
    !empty($data->phone) &&
    !empty($data->email) &&
    !empty($data->address) && 
    !empty($data->user_role)
){
 
    // set user property values
    $user->username = $data->username;
    $user->password = $data->password;
    $user->lastname = $data->lastname;
    $user->firstname = $data->firstname;
    $user->gender = $data->gender;
    $user->phone = $data->phone;
    $user->email = $data->email;
    $user->address = $data->address;    
    $user->user_role = $data->user_role;
 
    // create the user
    if($user->create()){
 
        // set response code - 201 created
        http_response_code(201);
        $RespCode = http_response_code(201);
 
        // tell the user
        echo json_encode(array("RespCode" => $RespCode,"exception" => "null", "RespMxg" => "success" , "RespObj" => "User Account Has Been Successfully Created", "RecordCount" => 0));
    }
 
    // if unable to create the user, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
        $RespCode = http_response_code(503);
 
        // tell the user
        echo json_encode(array("RespCode" => $RespCode,"exception" => "null", "RespMxg" => "failed" , "RespObj" => "Unable To Create User Account", "RecordCount" => 0));
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