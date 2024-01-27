<?php 
include_once('./database/connection.php');
require_once('./helpers/helper.php');
session_start();

if(isset($_SESSION['user_email'])){
    
    header("Location: profile.php");
    exit(); 
}


$emailError = $passwordError = "";
$email = $password = "";


 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if(empty($_POST["email"])){
        $emailError = "Email is required";
    }else{
        $email = sanitizeInput($_POST["email"]);
    }
    
    if(empty($_POST["password"])){
        $passwordError = "Password is required";
    }else{
        $password = sanitizeInput($_POST["password"]);
        
    }
    loginUser($email, $password);
    

    

  }


  function loginUser($email, $password){

    global $columnEmail, $connection, $passwordError, $emailError;

    $selectUserSQL = "SELECT * FROM users WHERE $columnEmail = ?";
    $selectUserStatement = $connection->prepare($selectUserSQL);
    $selectUserStatement->bind_param('s', $email);

    try{
      $selectUserStatement->execute();

      $result = $selectUserStatement->get_result();

      if($result->num_rows > 0){
        $userData = $result->fetch_assoc();
        if(password_verify($password, $userData['password'])){
          $_SESSION['user_email'] = $email;
          header('Location: profile.php');
          exit();
        }else{
          $passwordError = 'Invalid Password';
        }
      }else{
        $emailError = 'User not found';
      }
    }catch(Exception $userNotFoundExeption){
      echo $userNotFoundExeption;
    }
  }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/css/styles.css">
    <title>Login</title>
</head>
<body class="center-container">

<div>
<h1>Login</h1>
<br>
<form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
    <div>
  <label for="email">Email:</label><br>
  <input type="email" id="email" name="email" value=<?=$email?>><br>
  <span class="input-error"><?= $emailError?></span>
  </div>
  <div class="item-gap">
  <label for="password">Password:</label><br>
  <input type="password" id="password" name="password" value=<?=$password?>><br>
  <span class="input-error"><?= $passwordError?></span>
  </div>
  <input type="submit" class="auth-button" value="Submit">
</form>
</div>
</body>
</html>