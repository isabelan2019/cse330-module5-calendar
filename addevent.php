<?php
require 'database.php';
ini_set("session.cookie_httponly", 1);
session_start();
header("Content-Type: application/json"); 
$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);
$title=(string)$json_obj['title'];
$time=(string)$json_obj['time'];
$date=(string)$json_obj['date'];
$tag=(string)$json_obj['tag'];
if (!$tag) {
    $tag = NULL;
}

if(!isset($_SESSION['user_id'])){
    echo json_encode(array(
        "loggedin"=>htmlentities((bool)false)
    ));
    exit;
}
else{
    $user_id=(int)$_SESSION['user_id'];
    $token=(string)$json_obj['token'];

    //token does not pass
    if(!hash_equals($_SESSION['token'], $token)){
	   die("Request forgery detected");
    }
    if(empty($title) || empty($time) || empty($date)){
        echo json_encode(array(
            "success"=>htmlentities((bool)false),
            "message"=>htmlentities((string)"empty inputs")
        ));
        exit;
    }
    else{
        //pregmatch title 
        if( preg_match('/[|\#$%*+<>=?^_`{}~]+/', $title) ){
            echo json_encode(array(
                "invalid" => htmlentities((bool)true),
                "message" => htmlentities((string)"invalid title")
            ));
            exit;
        }

        //pregmatch time
        if( !preg_match('/^\d{2}:\d{2}$/', $time) ){
           echo json_encode(array(
               "invalid" => htmlentities((bool)true),
               "message" => htmlentities((string)"invalid time")
            ));
            exit;
        }
        //pregmatch date
        if( !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) ){
            echo json_encode(array(
                "invalid" => htmlentities((bool)true),
                "message" => htmlentities((string)"invalid date")
            ));
            exit;
        }


    $stmt=$mysqli->prepare("INSERT into events(user_id, title, date, time, tags) values(?,?,?,?,?)");
    if (!$stmt) {
        echo json_encode(array(
            "success" => htmlentities((bool)false),
            "message" => htmlentities((string)"ERROR inserting into database")
        ));
        exit;
    }
    $stmt->bind_param('issss',$user_id,$title,$date,$time, $tag);
    $stmt->execute();
    echo json_encode(array(
        "success" => htmlentities((bool)true)
    ));
    $stmt->close();
    }
}
?>

