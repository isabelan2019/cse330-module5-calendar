<?php

require 'database.php';

header("Content-Type: application/json"); 

$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);
$username = (string) $json_obj['username'];

//prepared statement
$stmt = $mysqli->prepare("SELECT COUNT(*), id, hashed_password from users where username=?");

//bind parameter
$stmt->bind_param('s',$username);

if( !preg_match('/^[\w_\-]+$/', $username) ){
	echo "Invalid username. You can only use alphanumeric characters, hyphens, and underscores.";
	exit;
}

$stmt->execute();

//bind results
$stmt->bind_result($cnt, $user_id, $pwd_hash);
$stmt->fetch();

//compare form password with database password
$pwd_guess = $json_obj['password'];

if($cnt==1 && password_verify($pwd_guess, $pwd_hash)){
    session_start();
    //login success
    $_SESSION['user_id'] = $user_id;
    //generate token
    $_SESSION['token'] = bin2hex(random_bytes(32));
    echo json_encode(array(
        "success" => true
    ));
    exit;
} else {
    echo json_encode(array(
        "success" => false,
        "message" => "Incorrect Username or Password"
    ));
    exit;
}

$stmt->close();

?>
