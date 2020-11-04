<?php
require 'database.php';
ini_set("session.cookie_httponly", 1);
session_start();
header("Content-Type: application/json"); 

if(isset($_SESSION['user_id'])==false){
    echo json_encode(array(
        "loggedin"=> htmlentities((bool) false)
    ));
    exit;
}

else{

$user_id= (int)$_SESSION['user_id'];
$username = (string)$_SESSION['username'];
$token = (string)$_SESSION['token'];
$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);
$personal = (bool)$json_obj['personal'];
$school = (bool)$json_obj['school'];
$work = (bool)$json_obj['work'];
$other = (bool)$json_obj['other'];

$eventsArray=array();

//events are added through each tag. goes through personal, then school, then work, then null tags. 
//shared events are not sorted
array_push($eventsArray,array(
    'user'=>(string)$_SESSION['username'],
    'token'=>(string)$_SESSION['token']
));
if ($personal == true) {

    $stmt = $mysqli->prepare("SELECT event_id, title, date, time, tags,group_id FROM events where user_id=? and tags='personal'");
    $stmt->bind_param('i',$user_id);
    if(!$stmt){
        echo json_encode(array(
            "success" => (bool) false,
            "message" => htmlentities((string)"ERROR checking database")
        ));
        exit;
    }

    $stmt->execute();

    //bind results
    $stmt->bind_result($personal_id, $personaltitle, $personaldate,$personaltime, $personaltags,$personalgroup_id);
    while($stmt->fetch()){   
        array_push($eventsArray, array(
            "event_id"=>array(htmlentities($personal_id)),
            "title"=>array(htmlentities($personaltitle)),
            "date"=>array(htmlentities($personaldate)),
            "time"=>array(htmlentities($personaltime)),
            "tags"=>array(htmlentities($personaltags)),
           // "token"=>$_SESSION['token'],

            'username'=>htmlentities($_SESSION['username']),
            'group_id'=>$personalgroup_id

        ));
    }
    $stmt->close();

}
if ($school == true) {

    $stmt = $mysqli->prepare("SELECT event_id, title, date, time, tags,group_id FROM events where user_id=? and tags='school'");
    $stmt->bind_param('i',$user_id);
    if(!$stmt){
        echo json_encode(array(
            "success" => (bool) false,
            "message" => htmlentities((string)"ERROR checking database")
        ));
        exit;
    }

    $stmt->execute();

    //bind results
    $stmt->bind_result($school_id, $schooltitle, $schooldate,$schooltime, $schooltags,$schoolgroup_id);
    while($stmt->fetch()){   
        array_push($eventsArray, array(
            "event_id"=>array(htmlentities($school_id)),
            "title"=>array(htmlentities($schooltitle)),
            "date"=>array(htmlentities($schooldate)),
            "time"=>array(htmlentities($schooltime)),
            "tags"=>array(htmlentities($schooltags)),
          //  "token"=>$_SESSION['token'],

          'username'=>htmlentities((string)$_SESSION['username']),
          'group_id'=>$schoolgroup_id
        ));
    }
    $stmt->close();

}

if ($work == true) {

    $stmt = $mysqli->prepare("SELECT event_id, title, date, time, tags,group_id FROM events where user_id=? and tags='work'");
    $stmt->bind_param('i',$user_id);
    if(!$stmt){
        echo json_encode(array(
            "success" => htmlentities( (bool)false),
            "message" => htmlentities((string)"ERROR checking database")
        ));
        exit;
    }

    $stmt->execute();

    //bind results
    $stmt->bind_result($work_id, $worktitle, $workdate,$worktime, $worktags,$workgroup_id);
    while($stmt->fetch()){   
        array_push($eventsArray, array(
            "event_id"=>array(htmlentities($work_id)),
            "title"=>array(htmlentities($worktitle)),
            "date"=>array(htmlentities($workdate)),
            "time"=>array(htmlentities($worktime)),
            "tags"=>array(htmlentities($worktags)),
           // "token"=>$_SESSION['token'],

            'username'=>htmlentities((string)$_SESSION['username']),
            'group_id'=>$workgroup_id
        ));
    }
    $stmt->close();

}


if ($other == true){
    $stmt = $mysqli->prepare("SELECT event_id, title, date, time, tags,group_id FROM events where user_id=? and tags is NULL");
    $stmt->bind_param('i',$user_id);
    if(!$stmt){
        echo json_encode(array(
            "success" => htmlentities((bool)false),
            "message" => htmlentities((string)"ERROR checking database")
        ));
        exit;
    }

    $stmt->execute();

    //bind results
    $stmt->bind_result($event_id, $title, $date,$time, $tags,$group_id);
    while($stmt->fetch()){   
        array_push($eventsArray, array(
            "event_id"=>array(htmlentities($event_id)),
            "title"=>array(htmlentities($title)),
            "date"=>array(htmlentities($date)),
            "time"=>array(htmlentities($time)),
            "tags"=>array(htmlentities($tags)),
         //   "token"=>$_SESSION['token'],

            'username'=>htmlentities((string)$_SESSION['username']),
            'group_id'=>$group_id
        ));
    }
    //echo json_encode($eventsArray);
    $stmt->close();


}


//FOR SHARE CALENDAR FUNCTIONALITY
//check shares table 
$stmt = $mysqli->prepare("SELECT COUNT(*), sender_id from shares where receiver_id=?");

$stmt->bind_param('i', $user_id);
if(!$stmt){
    echo json_encode(array(
        "success" => htmlentities((bool) false),
        "message" => htmlentities((string)"ERROR checking database")
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
        "success" => htmlentities((bool)false),
        "message" => htmlentities("ERROR checking database")
    ));
    exit;
}

$stmt->execute();

//bind results
$stmt->bind_result($sharedevent_id, $sharedtitle, $shareddate,$sharedtime, $sharedtags);
while($stmt->fetch()){   
    array_push($eventsArray, array(

        "event_id"=>array(htmlentities($sharedevent_id)),
        "title"=>array(htmlentities($sharedtitle)),
        "date"=>array(htmlentities($shareddate)),
        "time"=>array(htmlentities($sharedtime)),
        'tags'=>array(htmlentities($sharedtags)),
       // "token"=>$_SESSION['token'],
        'username'=>htmlentities('shared')
    ));
}

echo json_encode($eventsArray);
$stmt->close();

}

?>