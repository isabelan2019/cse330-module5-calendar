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

    //check if it's a group event that the user has access to
    // $stmt = $mysqli->prepare("SELECT COUNT(*), group_id from events where event_id=? AND user_id=?");
    // //bind parameter
    // $stmt->bind_param('ii', $event_id,$user_id);
    // if(!$stmt){
    //     echo json_encode(array(
    //     "success" => false,
    //     "message" => "ERROR checking database"
    // ));
    // exit;
    // }
    // $stmt->execute();

    // //bind results
    // $stmt->bind_result($cnt,$group_id);
    // $stmt->fetch();
    // if($cnt==0){
    //     echo json_encode(array(
    //         "success"=>false,
    //         "message"=>"ERROR accessing event"
    //     ));
    // }
    // else if($group_id!==null){
    //     $get_group_id=$group_id;
    // }
    // $stmt->close();
    //if this is not a group event then delete by event_id and check for user_id
    // if($get_group_id==null){
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
    // }
    // else{
    //     $stmt=$mysqli->prepare("DELETE from events where group_id=?");
    //     if (!$stmt) {
    //         echo json_encode(array(
    //             "success" => false,
    //             "message" => "ERROR checking database"
    //         ));
    //         exit;
    //     }
    //     $stmt->bind_param('i',$get_group_id);
    //     $stmt->execute();
    //     echo json_encode(array(
    //         "success" => true
    //     ));
    //     $stmt->close();
    // }
    
    
    }




?>