<?php
require 'database.php';
ini_set("session.cookie_httponly", 1);
session_start();
header("Content-Type: application/json"); 
$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);
$shareuser = $json_obj[(string)'sharecal'];

if(!isset($_SESSION['user_id'])){
    //ideally would never happen
    echo json_encode(array(
        "loggedin"=>false
    ));
    exit;
} 
else {
    $user_id=(int)$_SESSION['user_id'];
    if(empty($shareuser) ){
        echo json_encode(array(
            "success"=>false,
            "message"=>"empty inputs"
        ));
        exit;
    }
    else {

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

        //get all the events that will be shared
        $sharedevents = array();
        $stmt=$mysqli->prepare("SELECT title, date, time, tags from events where user_id=?");
        $stmt->bind_param('i',$user_id);
        if (!$stmt) {
            echo json_encode(array(
                "success" => false,
                "message" => "ERROR getting event from database"
            ));
            exit;
        }
        
        $stmt->execute();
        $stmt->bind_result($sharetitles,$sharedates,$sharetimes, $sharetags);
        while ($stmt->fetch()){
            array_push($sharedevents, array(
                'eventtitles'=>$sharetitles,
                'eventdates'=>$sharedates,
                'eventtimes'=>$sharetimes,
                'sharetags'=>$sharetags
            ));
        }
        //echo json_encode($sharedevents);
        $stmt->close();
        
        //add new event where the new user is shareuser
        // for ($i=0; $i<=count($sharedevents); $i++){
        //     $stmt=$mysqli->prepare("INSERT into events(user_id, title, date, time, tags) values(?,?,?,?,?)");
        //     if (!$stmt) {
        //         echo json_encode(array(
        //             "success" => false,
        //             "message" => "ERROR inserting into database"
        //         ));
        //         exit;
        //     }
        //     $stmt->bind_param('issss',$shareid,$sharetitles[$i],$sharedates[$i],$sharetimes[$i], $sharetags[$i]);
        //     $stmt->execute();
        //     $stmt->close();
        // }
        // echo json_encode(array(
        //     "success" => true
        // ));
       // exit;
        

    }


}


?>
