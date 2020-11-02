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

        //check if shareuser is the same as current 
        if ($user_id == $shareid){
            echo json_encode(array(
                "sameuser" => true,
            ));
            exit;
        }

        //add share data to mysql 
        $stmt=$mysqli->prepare("insert into shares (sender_id, receiver_id) values (?,?) ");
        $stmt->bind_param('ii',$user_id, $shareid);
        if (!$stmt) {
            echo json_encode(array(
                "success" => false,
                "message" => "ERROR getting event from database"
            ));
            exit;
        }
        $stmt->execute();
        echo json_encode(array(
            "success" => true
        ));
        $stmt->close();

    }


}


?>
