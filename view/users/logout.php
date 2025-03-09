<?php
session_start(); // Start the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to your login page
header("Location: http://localhost/IT322/login.php");
exit();
?>
