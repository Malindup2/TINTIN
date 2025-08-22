<?php
/**
 * Logout Script
 * Destroys user session and redirects to login page
 */

session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: login.php");
exit;
?>
