<?php 


//require_once 'lib/Log.php';
//require_once 'lib/SMSSender.php';
//require_once 'lib/SMSReceiver.php';

//define('SERVER_URL', 'http://localhost:7000/sms/send');	
//define('SERVER_URL', 'http://localhost:8080/sms');	
//define('APP_ID', 'APPID');
//define('APP_PASSWORD', 'password');

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


//$receiver = new SMSReceiver(file_get_contents('php://input'));
$receiver="sasdasd";
$game_arr=$conn->query("select id  from game where gameState=0");
echo $game_arr->num_rows;





handle($receiver,$conn);



function handle($receiver,$conn){


//$message = $receiver->getMessage(); // Get the message sent to the app
//$address = $receiver->getAddress(); // Get the phone no from which the message was sent 
$address='tel4';

$statsOfUser=$conn->query("select status from user  where hash='".$address."'");
$row = $statsOfUser->fetch_assoc();
if ($row["status"]==2) {
    
	entergame($receiver,$conn);
    
}


}


function entergame($receiver,$conn){

	 // $address = $receiver->getAddress(); 
	 $address='tel4';
	$game_arr=$conn->query("select *  from game where gameState=0");
   echo "strinnnng<br>";
    if ($game_arr->num_rows==0) {
    	
    	        $conn->query("INSERT INTO game  (player1Hash,gameState) VALUES ('".$address."',0) ");
       $game=$conn->query("select * from game where player1Hash='".$address."'");
        $sgame=$game->fetch_assoc();
        echo $sgame["id"]."<br>";
        $conn->query("INSERT INTO player  (playerHash,game_id,place,group_ch) VALUES ('".$address."',".$sgame["id"].",1,'A') ");
        echo "first<br>";


        # code...
    }
    else{

    	$game=$game_arr->fetch_assoc();
    	//var_dump($game);
    if (! isset($game["player2Hash"]) ) {
    	  $conn->query("INSERT INTO player  (playerHash,game_id,place,group_ch) VALUES ('".$address."',".$game["id"].",2,'B') ");
    	  $conn->query("update game set player2Hash='".$address."' where id=".$game["id"]);
    	  echo $game["id"];
    	  echo "player2Hash";
    }

    elseif ( !isset($game["player3Hash"]) ) {
    	 $conn->query("INSERT INTO player  (playerHash,game_id,place,group_ch) VALUES ('".$address."',".$game["id"].",3,'A') ");
    	  $conn->query("update game set player3Hash='".$address."' where id=".$game["id"]);
    	  echo "player3Hash";
    }

    elseif (! isset($game["player4Hash"])) {
    	 $conn->query("INSERT INTO player  (playerHash,game_id,place,group_ch) VALUES ('".$address."',".$game["id"].",4,'B') ");
    	  $conn->query("update game set player4Hash='".$address."' where id=".$game["id"]);

    	   $conn->query("update game set gameState=1 where id=".$game["id"]);
    	  echo "player4Hash";


    }
}

    $conn->query("update user set status=3 where hash='".$address."'");
    

}

	



 ?>