<?php

session_start();

function logout(){
    session_unset();
    session_destroy();
}

// Check if the request is a POST request and if the action is "logout"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'logout') {
    logout();
    exit();
}