<?php
	// Database credentials
	define('DB_SERVER', '127.0.0.1:3306');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', 'Password');
	define('DB_NAME', 'videon');
 
	/* Attempt to connect to MySQL database */
	$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
	// Check connection
	if($mysqli === false){
    	die("ERROR: Could not connect. " . $mysqli->connect_error);
	}
?>