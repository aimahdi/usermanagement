<?php
$serverName = "localhost";
$databaseUserName = "root";
$databasePassword = "root12345";
$databaseName = 'usermanagementsystem';

try{
    $connection = mysqli_connect($serverName, $databaseUserName, $databasePassword);
}catch(Exception $connectionException){
    die("Connection failed: " . mysqli_connect_error());
}

$createDatabaseSQL = "CREATE DATABASE IF NOT EXISTS $databaseName";

try{
    mysqli_query($connection, $createDatabaseSQL);
}catch(Exception $databaseCreationException){
    die("Error creating database: " . mysqli_error($connection));
}

$connection->select_db($databaseName);

$columnFirstName = 'first_name';
$columnLastName = 'last_name';
$columnPhone = 'phone';
$columnGender = 'gender';
$columnEmail = 'email';
$columnPassword = 'password';

$createTableSQL = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    $columnFirstName VARCHAR(30) NOT NULL,
    $columnLastName VARCHAR(30) NOT NULL,
    $columnPhone VARCHAR(20) NOT NULL,
    $columnGender VARCHAR(10) NOT NULL,
    $columnEmail VARCHAR(50) NOT NULL UNIQUE,
    $columnPassword VARCHAR(100) NOT NULL
)";

try{
    $connection->query($createTableSQL);
}catch(Exception $createTableException){
    echo "Error creating table: " . $connection->error;
}

?>