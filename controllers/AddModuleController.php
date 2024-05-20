<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');
if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 2) {
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $name = mysqli_real_escape_string($conn,$_REQUEST['name']);
            $nom_filiere = $_SESSION['fil_nom'];
            $id_dep = $_SESSION['dep_id'];
            $niveau = mysqli_real_escape_string($conn,$_REQUEST['niveau']);
            $semestre = mysqli_real_escape_string($conn,$_REQUEST['semestre']);

            $qr = mysqli_query($conn,"UPDATE module set
                name = '$name',niveau = '$niveau',semestre = '$semestre' where id='$id'");
                if ($qr) {
                    $_SESSION['message']= "1";
                    header("Location:/ENSAHify/views/coordinateur/module-management/view_module.php");
                } else {
                    $_SESSION['message'] = "0";
                    header("Location:/ENSAHify/views/coordinateur/module-management/view_module.php");
                }
            }
        else{
        $nom_filiere = $_SESSION['fil_nom'];
        $id_dep = $_SESSION['dep_id'];
        $name = mysqli_real_escape_string($conn,$_REQUEST['name']);
        $niveau = mysqli_real_escape_string($conn,$_REQUEST['niveau']);
        $semestre = mysqli_real_escape_string($conn,$_REQUEST['semestre']);

        $qr = mysqli_query($conn,"INSERT into module (
           name,nom_filiere,niveau,semestre,id_dep) values (
            '".$name."','".$nom_filiere."','".$niveau."','".$semestre."','".$id_dep."')");
            if ($qr) {
                $_SESSION['message'] = "1";
                header("Location:/ENSAHify/views/coordinateur/module-management/view_module.php");
            } else {
                $_SESSION['message'] = "0";
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