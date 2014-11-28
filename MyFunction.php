<?php

$cardSet="Spade-9 Diamond-K Spade-A Spade-K";
$triump = "Clubs";

function PrintArray($array){
	$arrlength = count($array);

	for($x = 0; $x < $arrlength; $x++) {
		
		echo "$array[$x]\n";
	}

}

function SplitMessage($cardSet){
	//defining arrays
	$tempArray = array();
	$typeArray = array();
	$valueArray = array();
	
	//Splitting the cardset using spaces
	$tempArray = explode(" ",$cardSet);
	
	//Iterate thrugh tempArray and split with -
	$arrlength = count($tempArray);

	for($x = 0; $x < $arrlength; $x++) {
		//printing array
    	echo "$tempArray[$x]\n";
		
		$splitted = explode("-",$tempArray[$x]);
		
		//appending it to different arrays
		//appending to typeArray
		//append tolower values
		array_push($typeArray,strtolower($splitted[0]));
		
		//appending to value array
		//assigning numbers to symbols
		$tmp=strtolower($splitted[1]);
		$assign = $tmp;
		if($tmp=="j"){
			$assign = 11;
		}
		elseif($tmp=="q"){
			$assign = 12;
		}
		elseif($tmp=="k"){
			$assign = 13;
		}
		elseif($tmp=="a"){
			$assign = 14;
		}
		else{
			$assign = $tmp;
		}
		//all is well
		array_push($valueArray,$assign);
	}
	
	//printing for testing
	PrintArray($typeArray);
	PrintArray($valueArray);
	
	//returning two arrays
	
	return array($typeArray,$valueArray);
	
	
}

/*
Function to get the winner by triumph
inputs are two arrays and triumph
typeArray and valueArray will have 4 members
return number is zero if no winner by this case
otherwise return winning position
*/

function getByTriump($typeArray,$valueArray,$triumph){
	$type =$typeArray;
	$value = $valueArray;
	$tri = $triumph;
	
	//get the winner as zero
	$winner = 0;
	
	$arrlength = count($type);
	
	//max triumph
	$maxTri=0;
	for($x = 0; $x < $arrlength; $x++) {
	
		//check array element is equal to triumph
		if(strcmp($type[$x],$tri)==0){
			//then found match one
			//check if it max
			
			if($maxTri<$value[$x]){
				//
				$maxTri = $value[$x];
				$winner = $x+1;
			}
		}
	}
	return $winner;
	
	
}

/*

When there is no winner using triumph
we can use the max value
This function will return that person
*/

function getByMax($typeArray,$valueArray){
	$type =$typeArray;
	$value = $valueArray;
	$firstCard = $typeArray[0];
	
	//get the winner as zero
	$winner = 0;
	
	$arrlength = count($type);
	
	//max value
	$maxVal=0;
	
	//chose the max value person
	for($x = 0; $x < $arrlength; $x++) {
	
		if(strcmp($firstCard,$type[$x])==0){
			if($maxVal<$value[$x]){
				$maxVal = $value[$x];
				$winner = $x+1;
			}
		}
		
	}
	return $winner;

}


function GetWinner($cardSet,$triumph) {
    echo "$cardSet\n";
	echo "$triumph\n";
	
	//lowering triumph
	$triumph = strtolower($triumph);
	
	$twoArrays = SplitMessage($cardSet);
	
	/*
	Now the two returning arrays come to twoArrays
	0 is typeArray
	1 is valueArray
	*/
	
	$typeArray = $twoArrays[0];
	$valueArray = $twoArrays[1];
	
	/*
	Now all values are separated, you can write the logic here
	*/
	$winner = 0;
	$winner = getByTriump($typeArray,$valueArray,$triumph);
	
	
	
	if($winner==0){
		echo "Winner cannot get from triumph\n";
		$winner = getByMax($typeArray,$valueArray);
		
		echo "Winner got by max value \n";
		echo "Winner is $winner \n";
		
		
		
	}else{
		echo "Winner got from triumph\n";
		echo "Winner is $winner \n";
		return $winner;
	}
	
}

GetWinner($cardSet,$triump);
?>