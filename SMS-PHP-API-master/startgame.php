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

function getNextCardPlay($dbConnection, $gameId, $currentPlayerPlace) {

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

// echo var_dump(getNextCardPlay($pdo, 1, 1)); // Example function


///
/// GET The winner of the round and set the player numbers
/// 

function setPlayerPlaceNumbers($dbConnection, $gameId, $winnerHash) {

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

// setPlayerPlaceNumbers($pdo, 1, 'tel:94722545855'); // demo


///////////////////////////////////////////////////////////////////////////
///
///GET truimph of the game
///

function GetTriumph($dbConnection, $gameId){

    $truimphQuery = $dbConnection->prepare("SELECT truimph FROM game WHERE id='".$gameId."'");
    $truimphQuery->execute();

    $truimph = $truimphQuery->fetch(PDO::FETCH_ASSOC);

    return $truimph["truimph"];
}

// GetTriumph($pdo, 1); // demo

///////////////////////////////////////////////////////////////////////////
///
///GET team of a player playing a game
///

function GetTeam($dbConnection, $playerHash,$gameId){

    $teamQuery = $dbConnection->prepare("SELECT * FROM player WHERE game_id='".$gameId."' AND playerHash='".$playerHash."'");
    $teamQuery->execute();

    $group = $teamQuery->fetch(PDO::FETCH_ASSOC);

    return $group["group"];
}

/*echo GetTeam($pdo, "tel:94722545854", 1); // demo

// Null check example
if(is_null(GetTeam($pdo, "tel:94722545854", 1))){
    echo "Yes, done";
}*/

///////////////////////////////////////////////////////////////////////////
///
///GET team of a player place
///

function GetPlayerPlace($dbConnection, $playerHash,$gameId){

    $playerPlace = $dbConnection->prepare("SELECT place FROM player WHERE game_id='".$gameId."' AND playerHash='".$playerHash."'");
    $playerPlace->execute();

    $place = $playerPlace->fetch(PDO::FETCH_ASSOC);

    return $place["place"];

}

// echo GetPlayerPlace($pdo, "tel:94722545854", 1); // demo

///////////////////////////////////////////////////////////////////////////
///
///GET game current hand result
///

function getCurrentHandResult($dbConnection, $gameId,$playerHash){        

    $marksQuery = $dbConnection->prepare("SELECT * FROM game WHERE id='".$gameId."'");
    $marksQuery->execute();

    $marksResult = $marksQuery->fetch(PDO::FETCH_ASSOC);
    $group1Marks = $marksResult["group1Marks"];
    $group2Marks = $marksResult["group2Marks"];


    $playerGroupQuery = $dbConnection->prepare("SELECT * FROM player WHERE game_id='".$gameId."' AND playerHash='".$playerHash."'");
    $playerGroupQuery->execute();

    $playerGroupResult = $playerGroupQuery->fetch(PDO::FETCH_ASSOC);
    $playerGroup = $playerGroupResult["group"];

    $message="";

    if($playerGroup =="A"){
        
        $message = "Win '".$group1Marks."' - Lost '".$group2Marks."'";
    }
    else{
        
        $message = "Win '".$group2Marks."' - Lost '".$group1Marks."'";
    
    }

    return $message;
}

// echo getCurrentHandResult($pdo,1, "tel:94722545854"); // demo

///////////////////////////////////////////////////////////////////////////
///
///GET current hand on desk
///

function getCurrentHandOnDesk($dbConnection,$gameId){
    
    $query = $dbConnection->prepare("SELECT currentHand FROM game WHERE id='".$gameId."'");
    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);
    $currentHand = $result["currentHand"];

    return $currentHand;
}

// echo getCurrentHandOnDesk($pdo, 1);


///////////////////////////////////////////////////////////////////////////
///
///GET player hand
///

function GetPlayerHand($dbConnection,$gameId,$playerHash){
    
    $query = $dbConnection->prepare("SELECT cardSet FROM player WHERE game_id='".$gameId."' AND playerHash='".$playerHash."'");
    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);
    $playerHand = $result["cardSet"];

    return $playerHand;
}

// echo GetPlayerHand($pdo, 1, "tel:94722545854");


/*
validate msg using first card

*/

// Complete
function validProper($dbConnection,$HandArray,$gameID,$playerID,$msg){

    //if he is first player then no validation should done
    $player = GetPlayerPlace($dbConnection,$playerID,$gameID);
    
    if($player==1){
        return 1;
    }
    else{
        //then validate as first card
        $currentCards = getCurrentHandOnDesk($dbConnection, $gameID);
        $currentCards = strtolower($currentCards);
        
        //separate values
        $curArray = explode(" ",$currentCards);
        
        //get the fist value
        
        $firstCard = $curArray[0];
        
        //get the type of first
        
        $firstAr = explode("-",$firstCard);
        
        //Now I have the first type
        $firstType = $firstAr[0];
        
        
        
        $HaveCard=0;
        
        //Iterate through HandArray
        $arrlength = count($HandArray);
        for($x = 0; $x < $arrlength; $x++) {
            
            $tmp = explode("-",$HandArray[$x]);
            $tmpType = strtolower($tmp[0]);
            
            //compare with first card
            if(strcmp($firstType,$tmpType)==0){
                $HaveCard=1;
            }
            
        }
        if($HaveCard==0){
            //He don't have the card
            //so cannot validate
            //all are acceptable
            return 1;
            
        }
        else{
            //He have card
            //check his message is this type
            
            $msgExp = explode("-",$msg);
            $msgNow = strtolower($msgExp[0]);
            
            if(strcmp($msgNow,$firstType)==0){
                //He is playing correct card
                return 1;
            }
            else{
                return 0;
            }
        }
        
        
        
    }
    
}

function validateMsg($dbConnection,$gameID,$playerID,$msg){
    
    //simple message
    $msg = strtolower($msg);
    
    //get hand from db do not query here
    $UserHand = GetPlayerHand($dbConnection,$gameID,$playerID);

    echo $UserHand;
    
    //get array from it
    $HandArray = explode(" ",$UserHand);
    
    //Valid Entry
    $validFirst = 0;
    
    $arrlength = count($HandArray);
    for($x = 0; $x < $arrlength; $x++) {
        
        //check in array
        if(strcmp($msg,strtolower($HandArray[$x]))==0){
        
            //so user entered what he have
            $validFirst = 1;
        }
        
    }
    
    if($validFirst==0){
        //invalid message
        return 0;
    }
    
    //now check he is intered an unproper card
    
    $validSecond = validProper($dbConnection,$HandArray,$gameID,$playerID,$msg);
    
    if($validSecond ==0){
        return 0;
    
    }else{
        return 1;
    }

}








//////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
///


/*
After sending to vidura
*/

function getNextPlayerNO($dbConnection, $currentPlayerPlace,$gameId){

    $nextCardPlayer = getNextCardPlay($dbConnection, $gameId, $currentPlayerPlace);

    return $nextCardPlayer["place"];
}

/*

should return next player id
*/
function getNextPlayerID($dbConnection,$currentPlayerPlace,$gameID){
    
    $nextCardPlayerHash = getNextCardPlay($dbConnection, $gameID, $currentPlayerPlace);

    return $nextCardPlayerHash["playerHash"];
}

/*
should edit current played string

*/
function saveEditedPlay($dbConnection,$gameID,$curEdit){

    //query and save
    return 1;
}


/*
remove the card from hand

*/
function removePrevCard($dbConnection,$playerID,$gameID,$msg){
    
    //get hand
    $hand = GetPlayerHand($dbConnection,$gameID,$playerID);
    
    echo "This is hand $hand \n";
    
    //explode and remove
    $HandAr = explode(" ",$hand);
    
    $newHand = "";
    
    //iterate and remove
    
    $arrlength = count($HandAr);
    
    echo "Going to edit this $arrlength\n";
    
    for($x = 0; $x < $arrlength; $x++) {
        
        $tmp = $HandAr[$x];
        echo "$tmp  $msg \n";
        if(strcmp(strtolower($tmp),strtolower($msg))==0){
            echo "Found removable object";
            
        }else{
            $newHand=$newHand." ".$tmp;
        }
    
    }
    
    //Now save $newHand
    echo "$newHand \n";

}


/*
Create the sending message for Unique Player

*/


function CreateReply($dbConnection,$playerID,$gameID,$msg){
    
    //Validate msg
    echo "Going to validate\n";
    $validate = validateMsg($dbConnection,$gameID,$playerID,$msg);
    if($validate == 0){
        return 0;
    }
    else{
        
        echo "Validate passed\n";
        $msgNew = "";
        
        //get the Next Person in the list
        $currentPlayerPlace = GetPlayerPlace($dbConnection, $playerID,$gameID);
        $NextPlayerNO = getNextPlayerNo($dbConnection,$currentPlayerPlace,$gameID);
        
        echo "Next Player $NextPlayerNO \n";
        
        //Get next player ID
        
        $NextPlayerID = getNextPlayerID($dbConnection,$currentPlayerPlace,$gameID);
        
        echo "Next Playerid $NextPlayerID \n";
    
        //Add triumph
        $msgNew = $msgNew.GetTriumph($dbConnection,$gameID)." |";
        
        echo "msg $msgNew  \n";
        
        //Add group
        $msgNew = $msgNew."Team ".GetTeam($dbConnection,$NextPlayerID,$gameID)." |";
        
        //Add player No
        $msgNew = $msgNew."Player ".$NextPlayerNO."\n";
        
        //Add win lost message
        
        $msgNew = $msgNew.getCurrentHandResult($dbConnection,$gameID,$NextPlayerID)."\n\n";
        
        //adding current playing string
        $curPlayed = getCurrentHandOnDesk($dbConnection,$gameID);
        
        //edit it
        $curEdit = $curPlayed . " ".$msg;
        
        
        //Save current edited play
        saveEditedPlay($dbConnection,$gameID,$curEdit);
        
        
        //edit message with curent edit
        $msgNew = $msgNew.$curEdit."\n";
        
        //remove previous person hand
        removePrevCard($dbConnection,$playerID,$gameID,$msg);
        
        
        //New card hand
        $newCardHand = GetPlayerHand($dbConnection,$gameID,$NextPlayerID);
        
        
        //add it into message
        $msgNew = $msgNew.$newCardHand;
        
        return $msgNew;
        
    
    }
    
    
}


$replymsg = CreateReply($pdo,"tel:94722545854","1","Spade-8");

echo "$replymsg";


?>