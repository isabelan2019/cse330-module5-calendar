<?php
require 'database.php';
ini_set("session.cookie_httponly", 1);
session_start();
header("Content-Type: application/json"); 
$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);

$new_title = (string)$json_obj['new-event-title'] ;
$new_date = (string)$json_obj[ "new-date"];
$new_time = (string)$json_obj[ "new-time"];
$event_id=(int)$json_obj["eventid"];
$tags=(string)$json_obj["new-tag"];
$get_group_id=null;


//$json_obj[(int) "eventid"];

if(!isset($_SESSION['user_id'])){
    echo json_encode(array(
        "loggedin"=>false
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

    if(empty($new_title) || empty($new_time) || empty($new_date)){
        echo json_encode(array(
        "success"=>false,
        "message"=>"empty inputs"
    ));
    exit;
    }
    else{
        //check if it's a group event
        //check if it's a group event that the user has access to
        $stmt = $mysqli->prepare("SELECT COUNT(*), group_id from events where event_id=? AND user_id=?");
        //bind parameter
        $stmt->bind_param('ii', $event_id,$user_id);
        if(!$stmt){
            echo json_encode(array(
            "success" => false,
            "message" => "ERROR checking database"
        ));
        exit;
        }
        $stmt->execute();

         //bind results
        $stmt->bind_result($cnt,$group_id);
        $stmt->fetch();
        if($cnt==0){
            echo json_encode(array(
                "success"=>false,
                "message"=>"ERROR accessing event"
            ));
        }
        else if($group_id!==null){
            $get_group_id=$group_id;
        }
        $stmt->close();

        //if this is not a group event then edit by event_id and check for user_id
        if($get_group_id==null){
            $stmt=$mysqli->prepare("update events set title=?, date=?, time=?,tags=? where event_id=? AND user_id=?");
            if (!$stmt) {
                echo json_encode(array(
                    "success" => false,
                    "message" => "ERROR inserting into database"
                ));
                exit;
            }
            $stmt->bind_param('ssssii',$new_title,$new_date,$new_time,$tags,$event_id,$user_id);
            $stmt->execute();
            echo json_encode(array(
                "success" => true
            ));
            $stmt->close();
            }
        else{
            $stmt=$mysqli->prepare("update events set title=?, date=?, time=?,tags=? where group_id=?");
            if (!$stmt) {
                echo json_encode(array(
                    "success" => false,
                    "message" => "ERROR inserting into database"
                ));
                exit;
            }
            $stmt->bind_param('ssssi',$new_title,$new_date,$new_time,$tags,$get_group_id);
            $stmt->execute();
            echo json_encode(array(
                "success" => true
            ));
            $stmt->close();
            }
        }
    }




?>