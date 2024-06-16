<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');
if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 3 || $_SESSION['user_data']['role'] == 2 || $_SESSION['user_data']['role'] == 1) {
        if(isset($_GET['updateid'])){
            $id = $_GET['updateid'];
            $id_module = $_GET['id_module'];
            $qr = mysqli_query($conn,"DELETE FROM attachments WHERE id = '$id'");
            if ($qr) {
                $_SESSION['message'] = "2";
                header("Location:/ENSAHify/views/professeur/attachements.php?id_module=$id_module");
            } else {
                $_SESSION['message'] = "3";
                header("Location:/ENSAHify/views/professeur/attachements.php?id_module=$id_module");
            }
        }
    }
}
?>