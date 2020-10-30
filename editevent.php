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
$event_id=$json_obj[(int)"eventid"];
$token=$json_obj['token'];

//$json_obj[(int) "eventid"];

if(!isset($_SESSION['user_id'])){
    echo json_encode(array(
        "loggedin"=>false
    ));
    exit;
}
else{
    $user_id=(int) $_SESSION['user_id'];

    //token does not pass
    if(!hash_equals($_SESSION['token'], $_POST['token'])){
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
}

exit;

?>