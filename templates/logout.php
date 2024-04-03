<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // If not logged in, redirect to the desired location
    header('Location: /templates/indexed.php');
    exit;
}

// Logout logic
if (isset($_GET['logout'])) { // Changed to GET method
    // Unset all of the session variables
    $_SESSION = [];

    // Destroy the session
    session_destroy();

    // Redirect to indexed.php page
    header('Location: /templates/indexed.php');
    exit;
}
?>
