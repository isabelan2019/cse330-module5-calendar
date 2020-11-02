<?php
require 'database.php';
ini_set("session.cookie_httponly", 1);
session_start();
header("Content-Type: application/json"); 

if(isset($_SESSION['user_id'])==false){
    echo json_encode(array(
        "loggedin"=>false
    ));
    exit;
}

else{

$user_id= (int)$_SESSION['user_id'];
$username = (string)$_SESSION['username'];
$token = $_SESSION['token'];
$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);
$personal = $json_obj['personal'];
$school = $json_obj['school'];
$work = $json_obj['work'];
$other = $json_obj['other'];

$eventsArray=array();
//events are added through each tag. goes through personal, then school, then work, then null tags. 
//shared events are not sorted
array_push($eventsArray,array(
    'user'=>$_SESSION['username'],
    'token'=>$_SESSION['token']
));
if ($personal == true) {

    $stmt = $mysqli->prepare("SELECT event_id, title, date, time, tags FROM events where user_id=? and tags='personal'");
    $stmt->bind_param('i',$user_id);
    if(!$stmt){
        echo json_encode(array(
            "success" => false,
            "message" => "ERROR checking database"
        ));
        exit;
    }

    $stmt->execute();

    //bind results
    $stmt->bind_result($personal_id, $personaltitle, $personaldate,$personaltime, $personaltags);
    while($stmt->fetch()){   
        array_push($eventsArray, array(
            "event_id"=>array($personal_id),
            "title"=>array($personaltitle),
            "date"=>array($personaldate),
            "time"=>array($personaltime),
            "tags"=>array($personaltags),
           // "token"=>$_SESSION['token'],
            'username'=>$_SESSION['username'],
         //   'group_id'=>$personalgroup_id
        ));
    }
    $stmt->close();

}
if ($school == true) {

    $stmt = $mysqli->prepare("SELECT event_id, title, date, time, tags FROM events where user_id=? and tags='school'");
    $stmt->bind_param('i',$user_id);
    if(!$stmt){
        echo json_encode(array(
            "success" => false,
            "message" => "ERROR checking database"
        ));
        exit;
    }

    $stmt->execute();

    //bind results
    $stmt->bind_result($school_id, $schooltitle, $schooldate,$schooltime, $schooltags);
    while($stmt->fetch()){   
        array_push($eventsArray, array(
            "event_id"=>array($school_id),
            "title"=>array($schooltitle),
            "date"=>array($schooldate),
            "time"=>array($schooltime),
            "tags"=>array($schooltags),
          //  "token"=>$_SESSION['token'],
          'username'=>$_SESSION['username'],
         // 'group_id'=>$schoolgroup_id
        ));
    }
    $stmt->close();

}

if ($work == true) {

    $stmt = $mysqli->prepare("SELECT event_id, title, date, time, tags FROM events where user_id=? and tags='work'");
    $stmt->bind_param('i',$user_id);
    if(!$stmt){
        echo json_encode(array(
            "success" => false,
            "message" => "ERROR checking database"
        ));
        exit;
    }

    $stmt->execute();

    //bind results
    $stmt->bind_result($work_id, $worktitle, $workdate,$worktime, $worktags);
    while($stmt->fetch()){   
        array_push($eventsArray, array(
            "event_id"=>array($work_id),
            "title"=>array($worktitle),
            "date"=>array($workdate),
            "time"=>array($worktime),
            "tags"=>array($worktags),
           // "token"=>$_SESSION['token'],
            'username'=>$_SESSION['username'],
           // 'group_id'=>$workgroup_id
        ));
    }
    $stmt->close();

}


if ($other == true){
    $stmt = $mysqli->prepare("SELECT event_id, title, date, time, tags FROM events where user_id=? and tags is NULL");
    $stmt->bind_param('i',$user_id);
    if(!$stmt){
        echo json_encode(array(
            "success" => false,
            "message" => "ERROR checking database"
        ));
        exit;
    }

    $stmt->execute();

    //bind results
    $stmt->bind_result($event_id, $title, $date,$time, $tags);
    while($stmt->fetch()){   
        array_push($eventsArray, array(
            "event_id"=>array($event_id),
            "title"=>array($title),
            "date"=>array($date),
            "time"=>array($time),
            "tags"=>array($tags),
         //   "token"=>$_SESSION['token'],
            'username'=>$_SESSION['username'],
           // 'group_id'=>$group_id
        ));
    }
    //echo json_encode($eventsArray);
    $stmt->close();


}



//check shares table 
$stmt = $mysqli->prepare("SELECT COUNT(*), sender_id from shares where receiver_id=?");

$stmt->bind_param('i', $user_id);
if(!$stmt){
    echo json_encode(array(
        "success" => false,
        "message" => "ERROR checking database"
    ));
    exit;
}

$stmt->execute();

//bind results
$stmt->bind_result($cnt, $sender_id);
$stmt->fetch();

//there are no calendars shared with the logged in user 
if (!$cnt>0) {
    echo json_encode($eventsArray);
    exit;
}
$stmt->close();


//gets shared calendars 
$stmt = $mysqli->prepare("SELECT event_id, title, date, time, tags FROM events where user_id=?");
$stmt->bind_param('i',$sender_id);
if(!$stmt){
    echo json_encode(array(
        "success" => false,
        "message" => "ERROR checking database"
    ));
    exit;
}

$stmt->execute();

//bind results
$stmt->bind_result($sharedevent_id, $sharedtitle, $shareddate,$sharedtime, $sharedtags);
while($stmt->fetch()){   
    array_push($eventsArray, array(
        "event_id"=>array($sharedevent_id),
        "title"=>array($sharedtitle),
        "date"=>array($shareddate),
        "time"=>array($sharedtime),
        'tags'=>array($sharedtags),
       // "token"=>$_SESSION['token'],
        'username'=>'shared'
    ));
}

echo json_encode($eventsArray);
$stmt->close();


}

?>