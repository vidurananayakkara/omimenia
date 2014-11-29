<?php

ini_set('error_log', 'ussd-app-error.log');

require 'libs/MoUssdReceiver.php';
require 'libs/MtUssdSender.php';
require 'class/operationsClass.php';
require 'libs/log.php';

require 'StartGame.php';


$production=false;

	if($production==false){
		$ussdserverurl ='http://localhost:7000/ussd/send';
	}
	else{
		$ussdserverurl= 'https://api.dialog.lk/ussd/send';
	}


$receiver 	= new UssdReceiver();
$sender 	= new UssdSender($ussdserverurl,'APP_000001','password');
$operations = new Operations();
$game_start = new game_start();


$content 			= 	$receiver->getMessage(); // get the message content
$address 			= 	$receiver->getAddress(); // get the sender's address
$requestId 			= 	$receiver->getRequestID(); // get the request ID
$applicationId 		= 	$receiver->getApplicationId(); // get application ID
$encoding 			=	$receiver->getEncoding(); // get the encoding value
$version 			= 	$receiver->getVersion(); // get the version
$sessionId 			= 	$receiver->getSessionId(); // get the session ID;
$ussdOperation 		= 	$receiver->getUssdOperation(); // get the ussd operation


$responseMsg = array(
    "main" =>  
    "OMI MANIA
1. Register
2. Help

99. Exit",

    "reg" =>
    "OMI MANIA
REGISTRATION

Enter Your User Name
    ",
    "start"=>
"
1.Want a Game
2.Unregister

99. Exit",

    "help"=>
  "Symbols
S - Spade
D - Diamond
C - Clubs
H - Hearts
A - Ace
K - King
Q - Queen
J - Jack

99. Back"
);


if ($ussdOperation  == "mo-init") { 
   
	try {



        $sql = "select * from user where hash='".$address."'";
        $query = mysql_query($sql);
        $user=mysql_fetch_array($query);

        $row = mysql_num_rows($query);

        if($row==0){

            $sessionArrary=array( "sessionid"=>$sessionId,"tel"=>$address,"menu"=>"main","pg"=>"","others"=>"");


            $sender->ussd($sessionId, $responseMsg["main"],$address );
        }else{

            $sessionArrary=array( "sessionid"=>$sessionId,"tel"=>$address,"menu"=>"Start","pg"=>"","others"=>$user["username"]);

            $sender->ussd($sessionId, "Hi ".$user["username"]. $responseMsg["start"],$address );
        }

  		$operations->setSessions($sessionArrary);

	} catch (Exception $e) {
			$sender->ussd($sessionId, 'Sorry error occured try again',$address );
	}
	
}else {

	$flag=0;

  	$sessiondetails=  $operations->getSession($sessionId);
  	$cuch_menu=$sessiondetails['menu'];
  	$operations->session_id=$sessiondetails['sessionsid'];

		switch($cuch_menu ){
		
			case "main": 	// Following is the main menu
					switch ($receiver->getMessage()) {
						case "1":
							$operations->session_menu="Register";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["reg"],$address );
							break;
						case "2":
							$operations->session_menu="Help";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["help"],$address );
							break;
						default:
							$operations->session_menu="main";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["main"],$address );
							break;
					}
					break;
            case "Register": // for registration goes here
				$operations->session_menu="Start";
				$operations->session_others=$receiver->getMessage();

                $sql_sessions_user="INSERT INTO `user` ( `username`, `score`, `hash`, `lastLoginTime`,`status`) VALUES
			    ('".$receiver->getMessage()."', 0, '".$address."', 'CURRENT_TIMESTAMP',0)";
                $quy_sessions_user=mysql_query($sql_sessions_user);

                $operations->saveSesssion();

				$sender->ussd($sessionId,'Hi '.$receiver->getMessage(). $responseMsg["start"],$address );
				break;
			case "Start": //for game to start goes here
                switch ($receiver->getMessage()) {
                    case "1":
                        $operations->session_menu="InGame";

                        //set user state to 1
                        $sql_sessions_user="UPDATE `user` SET `status`=1 WHERE `hash` =  '".$address."'";
                        $quy_sessions_user=mysql_query($sql_sessions_user);

                        $operations->saveSesssion();
                        $sender->ussd($sessionId,"Will join you quickly",$address,'mt-fin');

                        $game_start->check_players();
                        break;
                    case "2":
                        $operations->session_menu="Remove";
                        //should remove user here
                        $operations->saveSesssion();
                        $sender->ussd($sessionId,"Bye!",$address,'mt-fin');
                        break;
                    default:
                        $operations->session_menu="Register";
                        $operations->saveSesssion();

                        $sender->ussd($sessionId, "",$address );
                        break;
                }

				break;

			default: // default goto main menu
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Incorrect option',$address );
				break;
		}
	
}