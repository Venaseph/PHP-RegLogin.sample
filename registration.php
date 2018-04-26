<?php
// make connection
require_once 'connection.php';
 
// Initialize variables with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// When submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Create query
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind query with parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Execute, check if exists
            if($stmt->execute()){
                // save result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Not working as intended.";
            }
        }
         
        // Close query
        $stmt->close();
    }
    
    // Validate password
    if(empty(trim($_POST['password']))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST['password'])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST['password']);
    }
    
    // Check pass matches
    if(empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = 'Please confirm password.';     
    } else {
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password) {
            $confirm_password_err = 'Password did not match.';
        }
    }
    
    // Check for errors on all fields before insert
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        
        // Prepare query
        $sql = "INSERT INTO users (username, hash) VALUES (?, ?)";
         
        if($stmt = $mysqli->prepare($sql)) {
            // Bind variables to query as parameters
            $stmt->bind_param("ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash w salt
            
            // Attempt to execute the readyu to go query
            if($stmt->execute()){
                // Redirect to login page if win
                header("location: login.php");
            } else{
                echo "Not working as intended.";
            }
        }
         
        // Close query
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
}
?>