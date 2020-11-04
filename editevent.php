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
if (!$tags) {
    $tags = NULL;
}


//$json_obj[(int) "eventid"];

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

    if(empty($new_title) || empty($new_time) || empty($new_date)){
        echo json_encode(array(
        "success"=>htmlentities((bool)false),
        "message"=>htmlentities((string)"empty inputs")
    ));
    exit;
    }
    else{
        //check if the user has access to the event and retrieve value of the group_id (null or already set)
        $stmt = $mysqli->prepare("SELECT COUNT(*), group_id from events where event_id=? AND user_id=?");
        //bind parameter
        $stmt->bind_param('ii', $event_id,$user_id);
        if(!$stmt){
            echo json_encode(array(
            "success" => htmlentities((bool)false),
            "message" => htmlentities((string)"ERROR checking database")
        ));
        exit;
        }
        $stmt->execute();

         //bind results
        $stmt->bind_result($cnt,$group_id);
        $stmt->fetch();
        if($cnt==0){
            echo json_encode(array(
                "success"=>htmlentities((bool)false),
                "message"=>htmlentities((string)"ERROR accessing event")
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
                    "success" => htmlentities((bool)false),
                    "message" => htmlentities("ERROR inserting into database")
                ));
                exit;
            }
            $stmt->bind_param('ssssii',$new_title,$new_date,$new_time,$tags,$event_id,$user_id);
            $stmt->execute();
            echo json_encode(array(
                "success" => htmlentities((bool)true)
            ));
            $stmt->close();
            }
        else{
            $stmt=$mysqli->prepare("update events set title=?, date=?, time=?,tags=? where group_id=?");
            if (!$stmt) {
                echo json_encode(array(
                    "success" => htmlentities((bool)false),
                    "message" => htmlentities((string)"ERROR inserting into database")
                ));
                exit;
            }
            $stmt->bind_param('ssssi',$new_title,$new_date,$new_time,$tags,$get_group_id);
            $stmt->execute();
            echo json_encode(array(
                "success" => htmlentities((bool)true)
            ));
            $stmt->close();
            }
        }
    }




?>