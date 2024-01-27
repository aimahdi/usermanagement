<?php
session_start();

require_once('./database/connection.php');

$email = $_SESSION['user_email'];

if(!isset($email)){
    header('Location: index.php');
    exit();
}

$selectUserSQL = "SELECT * FROM users WHERE $columnEmail = ?";
$statement = $connection->prepare($selectUserSQL);
$statement->bind_param('s', $email);

try{
    $statement->execute();
    $result = $statement->get_result();
    $userData = $result->fetch_assoc();
}catch(Exception $userNotFoundException){
    echo $userNotFoundException;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/css/styles.css">
    <script src="./public/js/script.js"></script>
    <title>Profile</title>
</head>
<body>

<div>
    <div class="profile-section">
        <div class="profile-inner left-card">
            <div>
            <img src="./assets/vectors/profile_avater.jpg" width="200px" height="200px"alt="">
            <h5> <?=$userData['first_name'] . ' '. $userData['last_name'] ?></h5>
            <p>Job Title</p>
            <p>Department Name</p>
            </div>
        </div>
        <div class="profile-inner right-card">
            <div>
            <h1 style="text-align: center;">User Profile</h1>
                <p><span>First Name:</span> <?=$userData['first_name']?> </p>
                <hr>
                <p><span>Last Name:</span> <?=$userData['last_name']?></p>
                <hr>
                <p><span>Phone:</span> <?=$userData['phone']?> </p>
                <hr>
                <p><span>Gender:</span> <?=$userData['gender']?></p>
                <hr>
                <p><span>Email:</span> <?=$userData['email']?></p>
                <div>
                <button>Update Profile</button>
                <button id='logout'>Log Out</button>
                </div>
            </div>
        </div>
    </div>
</div>
    
</body>
</html>