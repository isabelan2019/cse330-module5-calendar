<?php
require 'database.php';
ini_set("session.cookie_httponly", 1);
session_start();
header("Content-Type: application/json"); 
$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);
$event_id=(int)$json_obj["eventid"];

if(!isset($_SESSION['user_id'])){
    echo json_encode(array(
        "loggedin"=>false
    ));
    exit;
}
else{
    $user_id=(int) $_SESSION['user_id'];
    $token=$json_obj['token'];
    //token does not pass
    if(!hash_equals($_SESSION['token'], $token)){
        die("Request forgery detected");
    }


    $stmt=$mysqli->prepare("delete from events where event_id=?");
    if (!$stmt) {
        echo json_encode(array(
            "success" => false,
            "message" => "ERROR checking database"
        ));
        exit;
    }
    $stmt->bind_param('i',$event_id);
    $stmt->execute();
    echo json_encode(array(
        "success" => true
    ));
    $stmt->close();
    }


exit;

?>