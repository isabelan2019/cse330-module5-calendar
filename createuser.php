<?php
//session_start();
require 'database.php';

header("Content-Type: application/json"); 

$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);

$newuser = (string) $json_obj['new-username'];

if( !preg_match('/^[\w_\-]+$/', $newuser) ){
	echo "Invalid username. You can only use alphanumeric characters, hyphens, and underscores.";
	exit;
}

$newpassword = password_hash((string)$json_obj['new-password'], PASSWORD_DEFAULT);

//checks username doesnt already exist
$stmt = $mysqli->prepare("SELECT COUNT(*) from users where username=?");

//bind parameter
$stmt->bind_param('s', $newuser);

if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->execute();

//bind results
$stmt->bind_result($cnt);
$stmt->fetch();

//if username already exists
if ($cnt>0) {
    //add something here
    exit;
}
$stmt->close();


$stmt = $mysqli->prepare("insert into users (username, hashed_password) values (?,?)");

if (!$stmt) {
    printf("Query Prep Failed: %s \n", $mysqli->error);
    echo json_encode(array(
        "success" => false,
        "message" => "Error"
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