<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['validerCoord']) && isset($_POST['cne']) && isset($_POST['module'])) {
        $cne_list = $_POST['cne'];
        $id_module = $_POST['module'];
        $grades = $_POST['grades'];

        foreach ($cne_list as $cne) {
            $grade = isset($grades[$cne]) ? $grades[$cne] : null;

            // Update the database record
            $update_query = "UPDATE notes SET valideCoord = 1 WHERE cne = '$cne' AND id_module = '$id_module'";
            mysqli_query($conn, $update_query);
        }

        $_SESSION['message'][] = "All grades have been successfully validated.";
    } else {
        $_SESSION['message'][] = "Error: Missing required data.";
    }

    // Redirect back to the previous page or to a success page
    header("Location: /ENSAHify/views/coordinateur/grades_page.php?id=$id_module");
    exit;
} else {
    header("Location: /ENSAHify/index.php?error=UnAuthorized Access");
    exit;
}
?>
