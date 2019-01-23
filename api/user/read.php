<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$user = new User($db);
 
// read user will be here
// query products
$stmt = $user->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
     $user_arr=array();
    $user_arr["RespObj"]=array();
    $RespCode = http_response_code(200);

 
    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $user_item=array(
            "user_id" => $user_id,
            "username" => $username,
            "lastname" => $lastname,
            "firstname" => $firstname,
            "gender" => $gender,
            "phone" => $phone,
            "email" => $email,
            "address" => $address,
            "user_role" => $user_role
        );
 
        array_push($user_arr["RespObj"], $user_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
    $RespCode = http_response_code(200);
 
    // show user data in json format
    echo json_encode(array("RespCode" => $RespCode,"exception" => "null", "RespMxg" => "success" , $user_arr, "RecordCount" => $num));
}


 
// no user found will be here
else{
 
    // set response code - 404 Not found
    http_response_code(404);
    $RespCode = http_response_code(404);
 
    // tell the user no user found
    echo json_encode(
        array("RespCode" => $RespCode,"RespMxg" => "Failed", "exception" => "null", "RespObj" => "No users found.", "RecordCount" => $num)
    );
}

?>