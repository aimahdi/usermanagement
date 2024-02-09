<?php

session_start();

if(isset($_SESSION['user_email'])){
    
    header("Location: profile.php");
    exit(); 
}

  
require_once('./helpers/helper.php');

$firstNameError = $lastNameError = $phoneError = $genderError = $emailError = $passwordError = $confirmPasswordError = "";
 $firstName = $lastName = $phone = $gender = $email = $password = $confirmPassword = "";


 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if(empty($_POST["first_name"])){
        $firstNameError = "First Name is required";
    }else{
        $firstName = sanitizeInput($_POST["first_name"]);
    }
    
    if(empty($_POST["last_name"])){
        $lastNameError = "Last Name is required";
    }else{
        $lastName = sanitizeInput($_POST["last_name"]);
    }
    
    if(empty($_POST["phone"])){
        $phoneError = "Phone is required";
    }else{
        $phone = sanitizeInput($_POST["phone"]);
    }
    if(empty($_POST["gender"])){
        $genderError = "Gender is required, please select one";
    }else{
        $gender = sanitizeInput($_POST["gender"]);
    }
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
    
    if(empty($_POST["confirm_password"])){
        $confirmPasswordError = "Password is required";
    }
    else{
        $confirmPassword = sanitizeInput($_POST["confirm_password"]);
        if($confirmPassword != $password){
            $confirmPasswordError = "Passwords does not match";
        }else{
            registerUser($firstName, $lastName, $phone, $gender, $email, $password);
        }
    }

    

  }


  function registerUser($firstName, $lastName, $phone, $gender, $email, $password){

    require_once('./database/connection.php');

    $password = password_hash($password, PASSWORD_DEFAULT);

    global $emailError;

    $createUserSQL = "INSERT INTO users ($columnFirstName, $columnLastName, $columnPhone, $columnGender, $columnEmail, $columnPassword)
    VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $connection->prepare($createUserSQL);
    $stmt->bind_param("ssssss", $firstName, $lastName, $phone, $gender, $email, $password);

    try {
        $stmt->execute();

        session_start();
        $_SESSION['user_email'] = $email;
        
        header("Location: profile.php");
        exit(); 
    } catch (Exception $createUserException) {
          $emailError = $stmt->error;
    }

    $stmt->close();
    $connection->close();
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
  <label for="phone">Phone:</label><br>
  <input type="phone" id="phone" name="phone" value=<?= $phone?>><br>
  <span class="input-error"><?= $phoneError?></span>
  </div>
  <div class="item-gap">
  <label for="gender">Gender:</label>
  <br>
  <div style="display: block; color: rebeccapurple; padding: 0;">
  <input type="radio" name="gender" value="female">Female
  <input type="radio" name="gender" value="male">Male
  <br>
  <span class="input-error"><?= $genderError?></span>
  </div>
  </div>
  <div class="item-gap">
  <label for="email">Email:</label><br>
  <input type="email" id="email" name="email"><br>
  <span class="input-error"><?= $emailError?></span>
  </div>
  <div class="item-gap">
  <label for="password">Password:</label><br>
  <input type="password" id="password" name="password"><br>
  <span class="input-error"><?= $passwordError?></span>
  </div>
  <div class="item-gap">
  <label for="confirm_password">Confirm Password:</label><br>
  <input type="password" id="confirm_password" name="confirm_password"><br>
  <span class="input-error"><?= $confirmPasswordError?></span>
  </div>
  <input type="submit" class="auth-button" value="Submit">
</form>
</div>
</body>
</html>