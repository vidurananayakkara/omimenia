<?php

require_once 'lib/Log.php';
require_once 'lib/SMSSender.php';
require_once 'lib/SMSReceiver.php';

// define('SERVER_URL', 'http://localhost:7000/sms/send');	
define("SERVER_URL", "http://localhost:8080/sms");	
define("APP_ID", "APPID");
define("APP_PASSWORD", "password");


require_once("db.php");

///
/// GET 4 players where status equals 2
/// 

/*$select_users = "SELECT * FROM user where status=0 limit 4";

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
}*/

///////////////////////////////////////////////////////////////////


///
/// GET 
/// 

/*$receiver = new SMSReceiver(file_get_contents('php://input'));
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

unset($query);*/


/////////////////////////////////////////////////////////////////////////////////////

///
/// GET The next card player
/// 

/*function getNextCardPlay($dbConnection, $gameId, $currentPlayerPlace) {

    $nextPlayer = 0;

    if($currentPlayerPlace > 0 && $currentPlayerPlace < 4){
        $nextPlayer = $currentPlayerPlace + 1;
    }else if($currentPlayerPlace == 4){
        $nextPlayer = 1;
    }else{
        echo "Invalid current player id";
    }

    $sqlQuery = $dbConnection->prepare("SELECT * FROM player WHERE game_id='".$gameId."' AND place='".$nextPlayer."'");
    $sqlQuery->execute();

    return $result = $sqlQuery->fetch(PDO::FETCH_ASSOC);
}

echo var_dump(getNextCardPlay($pdo, 1, 1)); // Example function*/


///
/// GET The winner of the round and set the player numbers
/// 

/*function setPlayerPlaceNumbers($dbConnection, $gameId, $winnerHash) {

    $winnerQuery = $dbConnection->prepare("SELECT * FROM player WHERE game_id='".$gameId."' AND playerHash='".$winnerHash."'");
    $winnerQuery->execute();

    $winnerCurrentPlace = $winnerQuery->fetch(PDO::FETCH_ASSOC);

    $array = array(1,2,3,4);
    $array = array_shift_circular($array, ($winnerCurrentPlace["place"] - 1));

    $allQuery = $dbConnection->prepare("SELECT * FROM player WHERE game_id='".$gameId."'");
    $allResult = $allQuery->execute();

    while($row = $allQuery->fetch()) {
        $newPlaceVal = $array[($row["place"]-1)];
        $updateQuery = $dbConnection->prepare("UPDATE player SET place='".$newPlaceVal."' WHERE game_id='".$gameId."' 
            AND playerHash='".$row["playerHash"]."'");
        $updateResult = $updateQuery->execute();
        echo var_dump($updateResult);
    }
}

function array_shift_circular(array $array, $steps = 1)
{
    if (!is_int($steps)) {
        throw new InvalidArgumentException('steps has to be an (int)');
    }
 
    if ($steps === 0) {
        return $array;
    }
 
    $l = count($array);
 
    if ($l === 0) {
        return $array;
    }
 
    $steps = $steps % $l;
    $steps *= -1;
 
    return array_merge(array_slice($array, $steps),array_slice($array, 0, $steps));
}

setPlayerPlaceNumbers($pdo, 1, 'tel:94722545855'); // demo*/


///////////////////////////////////////////////////////////////////////////
///
///GET
///






?>