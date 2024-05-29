<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');

if (!isset($_SESSION['user_data']) && isset($_COOKIE['remember'])) {
    list($selector, $validator) = explode(':', $_COOKIE['remember']);
    $selector = mysqli_real_escape_string($conn, $selector);
    $hashed_validator = hash('sha256', hex2bin($validator));

    $stmt = $conn->prepare("SELECT user_id, hashed_validator, expiry FROM user_tokens WHERE selector = ? AND expiry > NOW()");
    $stmt->bind_param("s", $selector);
    $stmt->execute();
    $stmt->bind_result($user_id, $db_hashed_validator, $expiry);
    if ($stmt->fetch() && hash_equals($db_hashed_validator, $hashed_validator)) {
        $stmt->close();

        $qr = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
        $data = mysqli_fetch_assoc($qr);
        $role_id = $data['role'];
        $role_query = mysqli_query($conn, "SELECT role FROM roles WHERE id = '$role_id'");
        $role_data = mysqli_fetch_assoc($role_query);
        $data['role_name'] = $role_data['role'];
        $_SESSION['user_data'] = $data;
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['role_name'] = $data['role_name'];

        $new_validator = random_bytes(32);
        $new_hashed_validator = hash('sha256', $new_validator);
        $new_expiry = date('Y-m-d H:i:s', strtotime('+30 days'));

        $update_stmt = $conn->prepare("UPDATE user_tokens SET hashed_validator = ?, expiry = ? WHERE selector = ?");
        $update_stmt->bind_param("sss", $new_hashed_validator, $new_expiry, $selector);
        $update_stmt->execute();
        $update_stmt->close();

        setcookie('remember', $selector.':'.bin2hex($new_validator), time() + (86400 * 30), "/", "", false, true);
    } else {
        $stmt->close();
        setcookie('remember', '', time() - 3600, "/");
    }
}
?>
