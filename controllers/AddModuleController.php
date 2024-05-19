<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');
if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 2) {
        if(isset($_GET['id'])){
            $id = $_POST['id'];
            $name = mysqli_real_escape_string($conn,$_REQUEST['name']);
            $id_filiere = $_SESSION['fil_id'];
            $id_dep = $_SESSION['dep_id'];

            $qr = mysqli_query($conn,"UPDATE module set
                name = '$name' where id='$id'");
                if ($qr) {
                    $_SESSION['message'][] = "2";
                    header("Location:/ENSAHify/views/coordinateur/module-management/view_module.php");
                } else {
                    $_SESSION['message'][] = "3";
                    header("Location:/ENSAHify/views/coordinateur/module-management/view_module.php");
                }
            }
        else{
        $id_filiere = $_SESSION['fil_id'];
        $id_dep = $_SESSION['dep_id'];
        $name = mysqli_real_escape_string($conn,$_REQUEST['name']);

        $qr = mysqli_query($conn,"INSERT into module (
           name,id_filiere,id_dep) values (
            '".$name."','".$id_filiere."','".$id_dep."')");
            if ($qr) {
                $_SESSION['message'][] = "1";
                header("Location:/ENSAHify/views/coordinateur/module-management/view_module.php");
            } else {
                $_SESSION['message'][] = "0";
                header("Location: /ENSAHify/views/coordinateur/module-management/view_module.php");
            }
        }
?>
<?php }
    else {
        header("Location: /ENSAHify/error.php");
    }
}else {
    header("Location: index.php?error=UnAuthorized Access");
}

?>