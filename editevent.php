<?php
require 'database.php';
ini_set("session.cookie_httponly", 1);
session_start();
header("Content-Type: application/json"); 
$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);

$new_title = $json_obj[(string)'new-event-title'] ;
$new_date = $json_obj[(string) "new-date"];
$new_time = $json_obj[(string) "new-time"];
$event_id=$json_obj["eventid"];
$tags=$json_obj["new-tag"];
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
    $token=$json_obj['token'];
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
        $stmt = $mysqli->prepare("SELECT group_id from events where event_id=?");
        //bind parameter
        $stmt->bind_param('i', $event_id);
        if(!$stmt){
            echo json_encode(array(
            "success" => false,
            "message" => "ERROR checking database"
        ));
        exit;
        }
        $stmt->execute();

        //bind results
        $stmt->bind_result($group_id);
        $stmt->fetch();
        if($group_id!==null){
            $get_group_id=$group_id;
        }
        $stmt->close();
        if($get_group_id==null){
            $stmt=$mysqli->prepare("update events set title=?, date=?, time=? where event_id=?");
            if (!$stmt) {
                echo json_encode(array(
                    "success" => false,
                    "message" => "ERROR inserting into database"
                ));
                exit;
            }
            $stmt->bind_param('sssi',$new_title,$new_date,$new_time,$event_id);
            $stmt->execute();
            echo json_encode(array(
                "success" => true
            ));
            $stmt->close();
            }
        else{
            $stmt=$mysqli->prepare("update events set title=?, date=?, time=? where group_id=?");
            if (!$stmt) {
                echo json_encode(array(
                    "success" => false,
                    "message" => "ERROR inserting into database"
                ));
                exit;
            }
            $stmt->bind_param('sssi',$new_title,$new_date,$new_time,$get_group_id);
            $stmt->execute();
            echo json_encode(array(
                "success" => true
            ));
            $stmt->close();
            }
        }
    }




?>