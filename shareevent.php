<?php
require 'database.php';
ini_set("session.cookie_httponly", 1);
session_start();
header("Content-Type: application/json"); 
$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);
$shareuser =  (string)$json_obj['shareuser'];
$eventid = (int)$json_obj['eventid'];

if(!isset($_SESSION['user_id'])){
    echo json_encode(array(
        "loggedin"=>false
    ));
    exit;
} 
else {
    $user_id=(int)$_SESSION['user_id'];
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

        //check if shareuser is the same as current 
        if ($user_id == $shareid){
            echo json_encode(array(
                "sameuser" => true,
            ));
            exit;
        }


        //get the event that will be shared
        $stmt=$mysqli->prepare("SELECT title, date, time, tags from events where event_id=?");
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

       // $username=$_SESSION['username'];
        
        //change group_id of the event being shared
        $stmt=$mysqli->prepare("UPDATE events set group_id=? where event_id=?");
        if (!$stmt) {
            echo json_encode(array(
                "success" => false,
                "message" => "ERROR inserting into database"
            ));
            exit;
        }
        $stmt->bind_param('ii',$eventid,$eventid);
        $stmt->execute();
        // echo json_encode(array(
        //     "success" => true
        // ));
        $stmt->close();
        

        
        //add new event where the new user is shareuser
        $stmt=$mysqli->prepare("INSERT into events(user_id, title, date, time, tags, group_id) values(?,?,?,?,?,?)");
        if (!$stmt) {
            echo json_encode(array(
                "success" => false,
                "message" => "ERROR inserting into database"
            ));
            exit;
        }
        $stmt->bind_param('issssi',$shareid,$sharetitle,$sharedate,$sharetime,$sharetag,$eventid);
        $stmt->execute();
        echo json_encode(array(
            "success" => true,
        ));
        $stmt->close();

        
    }
}


?>
