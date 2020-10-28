<?php
require 'database.php';
ini_set("session.cookie_httponly", 1);
session_start();
header("Content-Type: application/json"); 

if(isset($_SESSION['user_id'])==false){
    echo json_encode(array(
        "loggedin"=>false
    ));
    exit;
}

else{

$user_id=$_SESSION['user_id'];
$stmt = $mysqli->prepare("SELECT event_id, title, date, time FROM events where user_id=?");
$stmt->bind_param('i',$user_id);
if(!$stmt){
    echo json_encode(array(
        "success" => false,
        "message" => "ERROR checking database"
    ));
    exit;
}

$stmt->execute();
$eventsArray=array();

//bind results
$stmt->bind_result($event_id, $title, $date,$time);
while($stmt->fetch()){   
    array_push($eventsArray, array(
        "event_id"=>array($event_id),
        "title"=>array($title),
        "date"=>array($date),
        "time"=>array($time)
    ));
}
echo json_encode($eventsArray);
$stmt->close();
}

?>