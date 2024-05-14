<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();

// Check which user type is logged in and unset their session variable(s)
if (isset($_SESSION['member_id'])) {
    unset($_SESSION['member_id']);
} elseif (isset($_SESSION['admin_id'])) {
    unset($_SESSION['admin_id']);
} elseif (isset($_SESSION['dentist_id'])) {
    unset($_SESSION['dentist_id']);
} elseif (isset($_SESSION['super_id'])) {
    unset($_SESSION['super_id']);
}

// Destroy the session
//session_destroy();

// Redirect to the login page using JavaScript
echo '<script>window.location.href = "./login.php";</script>';
?>
