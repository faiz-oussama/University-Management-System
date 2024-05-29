<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');
// Remove all session variables
$user_id = $_SESSION['user_id'];

// Destroy the session
session_unset();
session_destroy();

if (isset($_COOKIE['remember'])) {
    list($selector, $validator) = explode(':', $_COOKIE['remember']);
    $stmt = $conn->prepare("DELETE FROM user_tokens WHERE selector = ? AND user_id = ?");
    $stmt->bind_param("si", $selector, $user_id);
    $stmt->execute();
    $stmt->close();

    // Clear the "Remember Me" cookie
    setcookie('remember', '', time() - 3600, "/");
}
// Redirect to login page
header("Location: /ENSAHify/index.php");
exit();
