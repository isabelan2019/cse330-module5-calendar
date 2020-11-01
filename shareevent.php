<?php
require 'database.php';
ini_set("session.cookie_httponly", 1);
session_start();
header("Content-Type: application/json"); 
$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);
$shareuser = $json_obj[(string)'shareuser'];
$eventid = (int)$json_obj['eventid'];

if(!isset($_SESSION['user_id'])){
    echo json_encode(array(
        "loggedin"=>false
    ));
    exit;
} 
else {
    $user_id=$_SESSION['user_id'];
    $token=$json_obj['token'];

    //token does not pass
    if(!hash_equals($_SESSION['token'], $token)){
        die("Request forgery detected");
    }
    if(empty($shareuser) ){
    echo json_encode(array(
        "success"=>false,
        "message"=>"empty inputs"
    ));
    exit;
    }
    else{
        //first check that shareuser exits
        $stmt = $mysqli->prepare("SELECT COUNT(*), id from users where username=?");
        //bind parameter
        $stmt->bind_param('s', $shareuser);
        if(!$stmt){
            echo json_encode(array(
            "success" => false,
            "message" => "ERROR checking database"
        ));
        exit;
        }
        $stmt->execute();

        //bind results
        $stmt->bind_result($cnt, $shareid);
        $stmt->fetch();

        //username does not exist
        if (!$cnt>0) {
            echo json_encode(array(
                "exists" => false,
            ));
            exit;
        }
        $stmt->close();


        //get the event that will be shared
        $stmt=$mysqli->prepare("SELECT title, date, time,tags from events where event_id=?");
        $stmt->bind_param('i',$eventid);
        if (!$stmt) {
            echo json_encode(array(
                "success" => false,
                "message" => "ERROR getting event from database"
            ));
            exit;
        }
        
        $stmt->execute();
        $stmt->bind_result($sharetitle,$sharedate,$sharetime, $sharetag);
        $stmt->fetch();
        $stmt->close();



        //add new event where the new user is shareuser
        $stmt=$mysqli->prepare("INSERT into events(user_id, title, date, time, tags) values(?,?,?,?)");
        if (!$stmt) {
            echo json_encode(array(
                "success" => false,
                "message" => "ERROR inserting into database"
            ));
            exit;
        }
        $stmt->bind_param('issss',$shareid,$sharetitle,$sharedate,$sharetime, $sharetag);
        $stmt->execute();
        echo json_encode(array(
            "success" => true,
        ));
        $stmt->close();

        
    }




}

?>
