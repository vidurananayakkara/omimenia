<?php

	try {
		$hostname = "localhost";
		$username = "root";
		$password = "";
		$dbname = "mydb";
    	$pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$password");
  	} catch (PDOException $e) {
    	echo "Failed to get DB handle: " . $e->getMessage() . "\n";
    	exit;
  	}

?>

