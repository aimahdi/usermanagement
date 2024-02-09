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
            <p>Job Title: <?= $userData['job_title']?></p>
            <p>Department: <?= $userData['department']?></p>
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
                <button id='update_profile_button'>Update Profile</button>
                <button id='logout'>Log Out</button>
                </div>
            </div>
        </div>
    </div>
    <div>
         <!-- Tabs -->

         <script>
            function openTab(tabId) {
        // Hide all tab contents
        var tabContents = document.getElementsByClassName('tab-content');
        for (var i = 0; i < tabContents.length; i++) {
            tabContents[i].classList.remove('active');
        }

        // Show the selected tab content
        document.getElementById(tabId).classList.add('active');
    }
         </script>
    <div class="tab">
        <button onclick="openTab('chats')">
            Doing
        </button>
        <button onclick="openTab('status')">
           To Do
        </button>
        <button onclick="openTab('calls')">
            Done
        </button>
    </div>
<br>
    <!-- Tab contents -->
    <div class="tab-container">
    <div class="tab-content" id="chats">
        <h3>Chats</h3>
        <p>This is the content for Chats tab.</p>
    </div>

    <div class="tab-content" id="status">
        <h3>Status</h3>
        <p>This is the content for Status tab.</p>
    </div>

    <div class="tab-content" id="calls">
        <h3>Calls</h3>
        <p>This is the content for Calls tab.</p>
    </div>
    </div>
    <button class="fab" onclick="handleButtonClick()">+</button>
    </div>
</div>
    
</body>
</html>