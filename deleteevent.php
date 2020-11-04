<?php
require 'database.php';
ini_set("session.cookie_httponly", 1);
session_start();
header("Content-Type: application/json"); 
$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);
$event_id=(int)$json_obj["eventid"];
$get_group_id=null;
if(!isset($_SESSION['user_id'])){
    echo json_encode(array(
        "loggedin"=>htmlentities((bool)false)
    ));
    exit;
}
else{
    $user_id=(int) $_SESSION['user_id'];
    $token=(string)$json_obj['token'];
    //token does not pass
    if(!hash_equals($_SESSION['token'], $token)){
        die("Request forgery detected");
    }

   
    $stmt=$mysqli->prepare("delete from events where event_id=? and user_id=?");
    if (!$stmt) {
        echo json_encode(array(
            "success" => htmlentities(false),
            "message" => htmlentities((string)"ERROR checking database")
        ));
        exit;
    }
    $stmt->bind_param('ii',$event_id,$user_id);
    $stmt->execute();
    echo json_encode(array(
        "success" => htmlentities((bool)true)
    ));
    $stmt->close();


}




?>