<?php

require_once 'lib/Log.php';
require_once 'lib/SMSSender.php';
require_once 'lib/SMSReceiver.php';

// define('SERVER_URL', 'http://localhost:7000/sms/send');	
define("SERVER_URL", "http://localhost:8080/sms");	
define("APP_ID", "APPID");
define("APP_PASSWORD", "password");


require_once("db.php");

$select_users = "SELECT * FROM user where status=0 limit 4";

$result = $pdo->query($select_users);

if ($result->rowCount() > 0) {
    while($row = $result->fetch()) {
    	// Send message to all the users
		$sender = new SMSSender( SERVER_URL, APP_ID, APP_PASSWORD);
		$response=$sender->sms('You have a game. If you ready send "Ready"', $row["hash"]);
        $pdo->query("update user set status=2 where hash=".$row["hash"]);
		// echo $row["hash"];
        // var_dump($row);
    }
} else {
    echo "0 results";
}

///////////////////////////////////////////////////////////////////


$receiver = new SMSReceiver(file_get_contents('php://input'));
$message = $receiver->getMessage(); // Get the message sent to the app
$address = $receiver->getAddress(); // Get the phone no from which the message was sent 


echo $message." ".$address;

$statsOfUser=$pdo->query("select status from user  where hash='".$address."'");

while($row = $statsOfUser->fetch()) {
    if ($row['status']==2) {
        $game=$pdo->query("select id  form game where gameState=0");
        if ($game->rowCount()==0) {
            $pdo->query("INSERT INTO game  (player1Hash,gameState) VALUES ('.$address',0) ");
            $game=$pdo->query("select id form game where player1Hash=".$address);

            // Code
        }
        $pdo->query("update user set status=3 where hash=".$address);
        $pdo->query("INSERT into player ");

        // Code
    }
}

unset($query);

?>