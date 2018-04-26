<?php
	// Database credentials
	define('DB_SERVER', '127.0.0.1:3306');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', 'Password');
	define('DB_NAME', 'videon');
 
	// Connect to MySQL database
	$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
	// Check connection errors
	if($mysqli === false){
    	die("ERROR: Not working as intended" . $mysqli->connect_error);
	}
?>