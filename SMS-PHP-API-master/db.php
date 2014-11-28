<?php

$servername = "localhost";
$username = "username";
$password = "password";

try {
    $conn = new PDO("mysql:host=$servername;dbname=myDB", $username, $password);
    echo "Connected successfully"; 
    }
catch(PDOException $e)
    {
    echo $e->getMessage();
}


