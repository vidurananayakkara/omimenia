<?php
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
	
	return 3;

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
	return "Spade-9 Diamond-A Diamond-7";

}



function GetHand($gameID,$playerID){
	
	//query player hand here
	
	return "Spade-9 Spade-A Diamond-9"; //query player hand
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


?>
