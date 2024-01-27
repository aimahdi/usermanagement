<?php
session_start();

if(isset($_SESSION['user_email'])){
    
    header("Location: profile.php");
    exit(); 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/css/styles.css">
    <title>Authentication</title>
</head>
<body class="center-container">
    <div>
        <h1>Welcome To user management system</h1>
        
        
        <div>
            <a href="./login.php" class="auth-button">Login</a>

            <a href="./register.php" class="auth-button">Register</a>
        </div>
    </div>
</body>
</html>

