<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');

if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 4) {
        if (isset($_GET['attachment_id'])) {
            $attachment_id = intval($_GET['attachment_id']);

            // Query to get the file information
            $query = "SELECT filename, filepath FROM attachments WHERE id = $attachment_id";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) == 1) {
                $attachment = mysqli_fetch_assoc($result);
                $filepath = $attachment['filepath'];
                $filename = $attachment['filename'];

                if (file_exists($filepath)) {
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename=' . basename($filename));
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($filepath));
                    readfile($filepath);
                    exit;
                } else {
                    echo "File not found.";
                }
            } else {
                echo "Error retrieving file information.";
            }
        } else {
            echo "Invalid request.";
        }
    } else {
        header("Location: /ENSAHify/error.php");
    }
} else {
    header("Location: index.php?error=Unauthorized Access");
}
?>
