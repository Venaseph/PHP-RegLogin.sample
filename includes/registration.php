<?php
require_once 'config.php';

// Set empty variables
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {

	//User Name Validation and Existance checking
	if(empty(trim($_POST["username"]))) {
		$username_err = "Please enter a username.";
	} else {
		// Prepare statement for db
		$sql = "SELECT id from users WHERE username = ?";
	
		if ($query = $mysqli->prepare($sql)){
			// Bind variables to the prepared statement as params
			$query->bind_param("s", $param_username);
			// Set Parameters
			$param_username = trim($_POST["username"]);


			// Attempt to execute the statement
			if($query->execute()) {
				// Store Result
				$query->store_result();

				// Check if email exists
				if($query->num_rows == 1) {
					$username_err = "This email account is already taken.";
				} else {
					$username = trim($_POST["username"]);
				}
		} else {
			echo "Opps! Connection failed. Please try again later";
		}
	}

	// Close Query
	$query->close();
}

    // Sanitize query
	function mysqlCleaner($data) {
		$data= mysql_real_escape_string($data);
		$data= stripslashes($data);
		return $data;
	}	


}