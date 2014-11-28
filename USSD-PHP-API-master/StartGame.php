<?php
/**
 * User: Dulanja
 * Date: 11/29/14
 * Time: 12:09 AM
 */

require 'db.php';
require_once 'libs/SMSSender.php';

define('SERVER_URL', 'http://localhost:7000/sms/send');
define('APP_ID', 'APP_000001');
define('APP_PASSWORD', 'password');
class game_start{

    function check_players(){

        $sql = "select * from user where status=1";
        $query = mysql_query($sql);
        if (!$query) { // add this check.
            error_log("here the error");
        }

        $users_name=array();
        $users_hash=array();
        $count=0;
        while ($row = mysql_fetch_array($query)) {
           error_log($row["username"]);


            $users_name[$count]=$row["username"];
            $users_hash[$count]=$row["hash"];
            $count++;

        }
        $num_users=count($users_name);
        //Creating a sender
        $sender = new SMSSender( SERVER_URL, APP_ID, APP_PASSWORD);
        if($num_users >= 4){

            for($i=0;$i<4;$i++){
                $sql_sessions_user="UPDATE `user` SET `status`=2 WHERE `hash` =  '".$users_hash[$i]."'";
                $quy_sessions_user=mysql_query($sql_sessions_user);
                // Send a SMS to a particular user
                $response=$sender->sms("If you are ready send ",$users_hash[$i]);
            }


        }
        error_log($num_users);

        mysql_free_result($query);

    }





}





?>