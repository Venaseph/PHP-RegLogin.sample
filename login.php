<?php
// Connect to DB
require_once 'connection.php';
 
// Initialize variables with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// When submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // Check username
    if(empty(trim($_POST["username"]))) {
        $username_err = 'Please enter username.';
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty 
    if(empty(trim($_POST['password']))) {
        $password_err = 'Please enter your password.';
    } else{
        $password = trim($_POST['password']);
    }
    
    // If neither are empty
    if(empty($username_err) && empty($password_err)) {
        // Prepare query
        $sql = "SELECT username, hash FROM users WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)) {
            // Bind name/pass to query as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Execute, check if exists
            if($stmt->execute()) {
                // Store result
                $stmt->store_result();
                
                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1) {                    
                    // Result storage again
                    $stmt->bind_result($username, $hashed_password);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            // Start a new session, save user name as a variable for output
                            session_start();
                            $_SESSION['username'] = $username;      
                            header("location: welcome.php");
                        } else {
                            // Display an error if bunk password
                            $password_err = 'The password you entered was not valid.';
                        }
                    }
                } else {
                    // User doesn't exist error
                    $username_err = 'No account found with that username.';
                }
            } else {
                echo "Not working as intended.";
            }
        }
        
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
}

// ugly but had to include down here to avoid issues with headers being created before they should.
include 'login.html';
?>