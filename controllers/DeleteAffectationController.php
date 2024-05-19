<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');
if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 2) {
        if(isset($_GET['updateid'])){
            $id = $_GET['updateid'];
            $qr = mysqli_query($conn,"Delete from affectationmoduleprof where id ='$id'");
        }
        if ($qr) {
            $_SESSION['message'][] = "2";
            header("Location:/ENSAHify/views/coordinateur/affectation-module/deleteAffectation.php");
        } else {
            $_SESSION['message'][] = "3";
            header("Location:/ENSAHify/views/coordinateur/affectation-module/deleteAffectation.php");
        }
    ?>


<?php 
    } else {
        header("Location: /ENSAHify/error.php");
    }
} else {
    header("Location: index.php?error=UnAuthorized Access");
}
?>