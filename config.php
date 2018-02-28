<?php

	$host_name = 'database ip';
	$database = 'database'; // Change your database name
	$username = 'user'; // Your database user id 
	$password = 'password'; // Your password
 
 
 //////// Do not Edit below /////////
 try {
 	$dbo = new PDO('mysql:host='.$host_name.';dbname='.$database, $username, $password);
 } catch (PDOException $e) {
 	print "Error!: " . $e->getMessage() . "<br/>";
 	die();
 }

?>