<?php

// Start the game 
// 

require_once 'lib/Log.php';
require_once 'lib/SMSSender.php';
require_once 'lib/SMSReceiver.php'

// define('SERVER_URL', 'http://localhost:7000/sms/send');	
define('SERVER_URL', 'http://localhost:8080/sms');	
define('APP_ID', 'APPID');
define('APP_PASSWORD', 'password');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 



//echo $statsOfUser;



$select_users = "SELECT * FROM user where status=1 limit 4";



$result = $conn->query($select_users);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    	// Send message to all the users
    	
		$sender = new SMSSender( SERVER_URL, APP_ID, APP_PASSWORD);

		$response=$sender->sms('You have a game. If you ready send "Ready"', $row["hash"]);
        $conn->query("update user set status=2 where hash=".$row["hash"])
		//echo $row["hash"];
    	//var_dump($row);
    }
} else {
    echo "0 results";
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


$receiver = new SMSReceiver(file_get_contents('php://input'));
$message = $receiver->getMessage(); // Get the message sent to the app
$address = $receiver->getAddress(); // Get the phone no from which the message was sent 
//$address='tell11111';

$statsOfUser=$conn->query("select status from user  where hash='".$address."'");

if ($statsOfUser==2) {
    $game=$conn->query("select id  form game where gameState=0");
    if ($game->num_rows=0) {
        $conn->query("INSERT INTO game  (player1Hash,gameState) VALUES (".$address",0) ");
        $game=$conn->query("select id form game where player1Hash=".$address);

        # code...
    }
    $conn->query("update user set status=3 where hash=".$address);
    $conn->query("INSERT into player ")

    
}

?>