<?php
require 'database.php';
ini_set("session.cookie_httponly", 1);
session_start();
header("Content-Type: application/json"); 
$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);
$title=$json_obj[(string)'title'];
$time=$json_obj[(string)'time'];
$date=$json_obj[(string)'date'];

if(!isset($_SESSION['user_id'])){
    echo json_encode(array(
        "loggedin"=>false
    ));
    exit;
}
else{
    $user_id=(int)$_SESSION['user_id'];
    $token=$json_obj['token'];

    //token does not pass
    if(!hash_equals($_SESSION['token'], $token)){
	   die("Request forgery detected");
    }
    if(empty($title) || empty($time) || empty($date)){
    echo json_encode(array(
        "success"=>false,
        "message"=>"empty inputs"
    ));
    exit;
   }
   else{

    $stmt=$mysqli->prepare("INSERT into events(user_id, title, date, time) values(?,?,?,?)");
    if (!$stmt) {
        echo json_encode(array(
            "success" => false,
            "message" => "ERROR inserting into database"
        ));
        exit;
    }
    $stmt->bind_param('isss',$user_id,$title,$date,$time);
    $stmt->execute();
    echo json_encode(array(
        "success" => true
    ));
    $stmt->close();
    }
}
?>

