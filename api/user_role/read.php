<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/user_role.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$user_role = new User_Role($db);
 
// read customer will be here
// query products
$stmt = $user_role->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $usersrole_arr=array();
    $usersrole_arr["RespObj"]=array();
    $RespCode = http_response_code(200);
 
    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $usersrole_item=array(
            "role_id" => $role_id,
            "role_name" => $role_name
        );
 
        array_push($usersrole_arr["RespObj"], $usersrole_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
    $RespCode = http_response_code(200);
 
    // show customer data in json format
    echo json_encode(array("RespCode" => $RespCode,"exception" => "null", "RespMxg" => "success" , $usersrole_arr, "RecordCount" => $num));
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