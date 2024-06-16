<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');
if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 1) {
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $qr = mysqli_query($conn,"DELETE FROM module WHERE id = '$id'");

            if ($qr) {
                $_SESSION['message'][] = "2";
                header("Location:/ENSAHify/views/chef_dep/module-management/view_module.php");
            } else {
                $_SESSION['message'][] = "3";
                header("Location: /ENSAHify/views/chef_dep/module-management/view_module.php");
            }
        }
    }
}
?>