function GetTriumph($gameID){
	//query the db
	//get Triump as gameId
	return "Diamond";
}

function GetTeam($playerID,$gameID){
	//query the db
	//get the team using PlayerID
	
	return "A";
	
}

function GetPlayerNo($playerID,$gameID){
	//query the db
	//get the player number
	
	return 1;

}

function getWinLost($gameID,$playerID){
	//query the db
	//get Group1Marks
	//get Group2Marks using query
	$msg="";
	
	$group1Marks = 3; //query here
	$group2Marks = 2; //query here
	if(GetTeam($playerID,$gameID) =="A"){
		
		$msg = "Win $group1Marks - Lost $group2Marks";
	}
	else{
		
		$msg = "Win $group2Marks - Lost $group1Marks";
	
	}
	return $msg;

}

/*

function that retuns current played cards
*/
function getCurrent($gameID){
	
	//query here
	return "Spade-9";

}



function GetHand($gameID,$playerID){
	
	//query player hand here
	
	return "Spade-8 Spade-A Diamond-9 Heart-9"; //query player hand
}


/*
validate msg using first card

*/

function validProper($HandArray,$gameID,$playerID,$msg){

	//if he is first player then no validation should done
	$player =GetPlayerNo($playerID,$gameID);
	
	if($player==1){
		return 1;
	}
	else{
		//then validate as first card
		$currentCards = getCurrent($gameID);
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


function validateMsg($gameID,$playerID,$msg){
	
	//simple message
	$msg = strtolower($msg);
	
	//get hand from db do not query here
	$UserHand = GetHand($gameID,$playerID);
	
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
	
	$validSecond = validProper($HandArray,$gameID,$playerID,$msg);
	
	if($validSecond ==0){
		return 0;
	
	}else{
		return 1;
	}
	
	

}

/*
After sending to vidura
*/

function getNextPlayerNO($playerID,$gameID){

	//query here
	//return next persone id
	return 2;
}

/*

should return next player id
*/
function getNextPlayerID($playerID,$gameID){

	//query here
	//return next player id
	return "0713222356";
}

/*
should edit current played string

*/
function saveEditedPlay($gameID,$curEdit){

	//query and save
	return 1;
}


/*
remove the card from hand

*/
function removePrevCard($playerID,$gameID,$msg){
	
	//get hand
	$hand = GetHand($gameID,$playerID);
	
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


function CreateReply($playerID,$gameID,$msg){
	
	//Validate msg
	echo "Going to validate\n";
	$validate = validateMsg($gameID,$playerID,$msg);
	if($validate == 0){
		return 0;
	}
	else{
		
		echo "Validate passed\n";
		$msgNew = "";
		
		//get the Next Person in the list
		
		$NextPlayerNO = getNextPlayerNo($playerID,$gameID);
		
		echo "Next Player $NextPlayerNO \n";
		
		//Get next player ID
		
		$NextPlayerID = getNextPlayerID($playerID,$gameID);
		
		echo "Next Playerid $NextPlayerID \n";
	
		//Add triumph
		$msgNew = $msgNew.GetTriumph($gameID)." |";
		
		echo "msg $msgNew  \n";
		
		//Add group
		$msgNew = $msgNew."Team ".GetTeam($NextPlayerID,$gameID)." |";
		
		//Add player No
		$msgNew = $msgNew."Player ".getNextPlayerNO($playerID,$gameID)."\n";
		
		//Add win lost message
		
		$msgNew = $msgNew.getWinLost($gameID,$NextPlayerID)."\n\n";
		
		//adding current playing string
		
		$curPlayed = getCurrent($gameID);
		
		//edit it
		$curEdit = $curPlayed . " ".$msg;
		
		
		//Save current edited play
		saveEditedPlay($gameID,$curEdit);
		
		
		//edit message with curent edit
		$msgNew = $msgNew.$curEdit."\n";
		
		//remove previous person hand
		removePrevCard($playerID,$gameID,$msg);
		
		
		//New card hand
		$newCardHand = GetHand($gameID,$NextPlayerID);
		
		
		//add it into message
		$msgNew = $msgNew.$newCardHand;
		
		return $msgNew;
		
	
	}
	
	
}


$replymsg = CreateReply("254425","2435245","Spade-8");

echo "$replymsg";
