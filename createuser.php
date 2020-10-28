<?php
//session_start();
require 'database.php';

header("Content-Type: application/json"); 

$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);

$newuser = (string) $json_obj['new-username'];

if( !preg_match('/^[\w_\-]+$/', $newuser) ){
	echo json_encode(array(
        "invalid"=> true,
        "message" => "Invalid characters"
    ));
	exit;
}

$newpassword = password_hash((string)$json_obj['new-password'], PASSWORD_DEFAULT);

//checks username doesnt already exist
$stmt = $mysqli->prepare("SELECT COUNT(*) from users where username=?");

//bind parameter
$stmt->bind_param('s', $newuser);

if(!$stmt){
    echo json_encode(array(
        "success" => false,
        "message" => "ERROR checking database"
    ));
    exit;
}

$stmt->execute();

//bind results
$stmt->bind_result($cnt);
$stmt->fetch();

//if username already exists
if ($cnt>0) {
    echo json_encode(array(
        "exists" => true,
    ));
    exit;
}
$stmt->close();


$stmt = $mysqli->prepare("insert into users (username, hashed_password) values (?,?)");

if (!$stmt) {
    echo json_encode(array(
        "success" => false,
        "message" => "ERROR inserting into database"
    ));
    exit;
}

$stmt->bind_param('ss', $newuser, $newpassword);
$stmt->execute();

echo json_encode(array(
    "success" => true
));
$stmt->close();

?>