<?php
	// Start Session
	session_start();
 
	// Reset all variables
	$_SESSION = array();
 
	// Blow up old
	session_destroy();
 
	// Redirect to login
	header("location: login.php");
	exit;
?>
