<?php
session_start();
require_once './database/connection.php';
require_once('./helpers/helper.php');

$email = $_SESSION['user_email'];
if(!isset($email)){

   header('Location: index.php');
    exit();
}

$firstNameError = $lastNameError = $phoneError = $genderError = $emailError = $jobTitleError = $departmentError = "";
$firstName = $lastName = $phone = $gender = $password = $confirmPassword = $jobTitle = $department= "";

$selectUserSQL = "SELECT * FROM users WHERE $columnEmail = ?";
$statement = $connection->prepare($selectUserSQL);

$statement->bind_param('s', $email);


try{
    $statement->execute();
    $result = $statement->get_result();
    $userData = $result->fetch_assoc();
    $firstName = $userData['first_name'];
    $lastName = $userData['last_name'];
    $phone = $userData['phone'];    
    $gender = $userData['gender'];
    $jobTitle = $userData['job_title'];
    $department = $userData['department'];

}catch(Exception $userNotFoundException){
    die($userNotFoundException);
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    $firstName = sanitizeInput($_POST['first_name']);
    $lastName = sanitizeInput($_POST['last_name']);
    $phone = sanitizeInput($_POST['phone']);
    $gender = sanitizeInput($_POST['gender']);
    $jobTitle = sanitizeInput($_POST['job_title']);
    $department = sanitizeInput($_POST['department']);
    updateUser();
}

function updateUser(){
    global $firstName, $lastName, $phone, $gender, $email, $jobTitle, $department;
    global $connection;
    $updateUSERSQL = 'Update users SET first_name = ?, last_name = ?, phone = ?, gender = ?, job_title = ?, department = ?
    WHERE email = ?';
    $updateUSERStatement = $connection->prepare($updateUSERSQL);
    $updateUSERStatement->bind_param('sssssss', $firstName, $lastName, $phone, $gender, $jobTitle, $department, $email);

    try{
        echo $updateUSERStatement->execute();
        header("Location: profile.php");
        exit(); 
    }catch(Exception $userUpdateException){
        die($userUpdateException);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/css/styles.css">
    <title>Registration</title>
</head>
<body class="center-container">

<div>
<h1>Register</h1>
<br>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div class="item-gap">
  <label for="first_name">First name:</label><br>
  <input type="text" id="first_name" name="first_name" value=<?= $firstName?>><br>
  <span class="input-error"><?= $firstNameError?></span>
  </div>
  <div class="item-gap">
  <label for="last_name">Last name:</label><br>
  <input type="text" id="last_name" name="last_name" value=<?= $lastName?>><br>
  <span class="input-error"><?= $lastNameError ?></span>
  </div>
  <div class="item-gap">
  <label for="phone">Phone: </label><br>

  <input type="text" id="phone" name="phone" value="<?= $phone ?>"><br>
  <span class="input-error"><?= $phoneError?></span>
  </div>
  <div class="item-gap">
  <label for="gender">Gender:</label>
  <br>
  <div style="display: block; color: rebeccapurple; padding: 0;">
  <input type="radio" name="gender" value="female" <?php if($gender =='female') echo 'checked'?>>Female
  <input type="radio" name="gender" <?php if($gender =='male') echo 'checked'?> value="male">Male
  <br>
  <span class="input-error"><?= $genderError?></span>
  </div>
  </div>
  <div class="item-gap">
  <label for="email">Email:</label><br>
  <input type="email" id="email" name="email" value="<?= $email?>" readonly><br>
  <span class="input-error"><?= $emailError?></span>
  </div>

  <div class="item-gap">
  <label for="job_title">Job Title:</label><br>
  <input type="text" id="job_title" name="job_title" value="<?= $jobTitle?>" ><br>
  <span class="input-error"><?= $jobTitleError?></span>
  </div>
  <div class="item-gap">
  <label for="department">Department:</label><br>
  <input type="text" id="department" name="department" value="<?= $department?>" ><br>
  <span class="input-error"><?= $departmentError?></span>
  </div>
  
  <input type="submit" class="auth-button" value="Submit">
</form>
</div>
</body>
</html>