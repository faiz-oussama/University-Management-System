<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');
if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 2) {
        $module = mysqli_real_escape_string($conn,$_REQUEST['Modulename']);
        $teacher = mysqli_real_escape_string($conn,$_REQUEST['teacherName']);

        $qr = mysqli_query($conn,"INSERT into affectationmoduleprof (
            id_teacher,id_module) values (
            '".$teacher."','".$module."')");
            if ($qr) {
                $_SESSION['message'][] = "1";
                header("Location:/ENSAHify/views/coordinateur/affectation-module/affectation.php");
            } else {
                $_SESSION['message'][] = "0";
                header("Location:/ENSAHify/views/coordinateur/affectation-module/affectation.php");
            }
?>
<?php } else {
        header("Location: /ENSAHify/error.php");
    }
}else {
    header("Location: index.php?error=UnAuthorized Access");
}

?>