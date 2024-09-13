<?php 
require 'config.php';

function registerUser($name, $email, $password) {
    global $pdo;
    try {
        // Validate input data
        if (empty($name) || empty($email) || empty($password)) {
            throw new Exception('All fields are required.');
        }
        
        // Check if email is already registered
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([htmlspecialchars($email)]);
        if ($stmt->rowCount() > 0) {
            throw new Exception('Email is already registered.');
        }

        // Hash the password and insert into the database
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([htmlspecialchars($name), htmlspecialchars($email), $hash]);
        
        $msg= "Registration successful!";
    } catch (Exception $e) {
        // Store the error message in the session
        $_SESSION['errorMessage'] = $e->getMessage();
        
        // Redirect back to the registration form
        header("Location: /register");  // Adjust the path as needed
        exit();
    }
}


?>