<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');

if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 2) {
        $module = mysqli_real_escape_string($conn, $_POST['Modulename']);
        $teacher = mysqli_real_escape_string($conn, $_POST['teacherName']);
        $id = isset($_POST['edit_id']) ? mysqli_real_escape_string($conn, $_POST['edit_id']) : null;

        if ($id) {
            $query = "UPDATE affectationmoduleprof SET id_module = '$module', id_teacher = '$teacher' WHERE id = '$id'";
            $result = mysqli_query($conn, $query);
            if ($result) {
                $_SESSION['message'][] = "1";
            } else {
                $_SESSION['message'][] = "0";
            }
        } else {
            $query = "INSERT INTO affectationmoduleprof (id_teacher, id_module) VALUES ('$teacher', '$module')";
            $result = mysqli_query($conn, $query);
            if ($result) {
                $_SESSION['message'][] = "1";
            } else {
                $_SESSION['message'][] = "0";
            }
        }

        header("Location: /ENSAHify/views/coordinateur/affectation-module/AfficheAffectation.php");
        exit();
    } else {
        header("Location: /ENSAHify/error.php");
        exit();
    }
} else {
    header("Location: /ENSAHify/index.php?error=UnAuthorized Access");
    exit();
}
?>
