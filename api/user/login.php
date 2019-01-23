<?php
// required headers

header("Access-Control-Allow-Origin: http://localhost:8080/mysportslog/api/");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';

// generate json web token
include_once '../config/core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;
 
// generate jwt will be here
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare customer object
$user = new User($db);
 
// set ID property of record to read
$user->username = isset($_GET['username']) ? $_GET['username'] : die();
$user->password = isset($_GET['password']) ? $_GET['password'] : die();
 
// read the details of user login
$stmt = $user->login();
$randomstrings = $user-> generateRandomString();
 
if($stmt->rowCount() > 0){
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // get token array
    $token = array(
        "iss" => $iss,
        "aud" => $aud,
        "iat" => $iat,
        "nbf" => $nbf,
        "data" => array(
            "user_id" => $row['user_id'],
            "username" => $row['username'],
            "lastname" => $row['lastname'],
            "firstname" => $row['firstname'],
            "gender" => $row['gender'],
            "phone" => $row['phone'],
            "email" => $row['email'],
            "address" => $row['address'],
            "user_role" => $row['user_role'],
            "key" => $randomstrings
        )
     );

     // generate jwt
     $jwt = JWT::encode($token, $key);


     // create array
    $user_arr=array(
        "user_id" => $row['user_id'],
        "username" => $row['username'],
        "lastname" => $row['lastname'],
        "firstname" => $row['firstname'],
        "gender" => $row['gender'],
        "phone" => $row['phone'],
        "email" => $row['email'],
        "address" => $row['address'],
        "user_role" => $row['user_role'],
        "token" => $jwt
    ); 
    // set response code - 200 OK
    http_response_code(200);
    $RespCode = http_response_code(200); 
    
 
        // make it json format
        echo json_encode(array("RespCode" => $RespCode, "RespMxg" => "success", "exception" => "null", "RespObj" => $user_arr, "RecordCount" => 1));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
    $RespCode = http_response_code(404);
    // tell the user customer does not exist
    echo json_encode(
    array("RespCode" => $RespCode,"RespMxg" => "Failed", "exception" => "null", "RespObj" => "No User Found. Incorrect Username/Password", "RecordCount" => 0)
    );
}
?>