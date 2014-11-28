
<?php
    /**
	
	This is flow after assigned every 4 user
	
	function ReadMessage()
	function GetUser()
	function QueryUser()
	function CheckUserStatus()
	function GiveHimAGame()
	
	function GetInputMessage()
		ReadMessage() --CALL
		GetUser()	--CALL
		QueryUser()	--CALL
		CheckUserStatus() --CALL
		
		IfUserStatus==2:
			Proceed
		Else:
			GiveHimAGame()	--CALL
		
	function GetTheRawFromDB()
	function FindNextPlayer()
	function FindWinner()
	function ChangePlayerOrder()
	function SendTextToPlayer()
	
	
	
	function HandleClient()
		GetTheRawFromDB()  --CALL
		FindNextPlayer()  --CALL
		If next player == 1:
			--this means round is over
			FindWinner()  --CALL 
			ChangePlayerOrder()  --CALL
			SendTextToPlayer()  --CALL
		Else:
			--this means round is in middle
			SendTextToPlayer() --CALL
		
		
		
	While True:
		GetInputMessage() --CALL
		HandleClient() -- CALL
	
	
	
	
	**/
?>