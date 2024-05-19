<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');
if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 2) {
        if(isset($_GET['id'])){
            $id = $_POST['id'];
            $prénom = mysqli_real_escape_string($conn,$_REQUEST['prénom']);
            $nom = mysqli_real_escape_string($conn,$_REQUEST['nom']);
            $role = mysqli_real_escape_string($conn,$_REQUEST['role']);
            $email = mysqli_real_escape_string($conn,$_REQUEST['email']);
            $cni = mysqli_real_escape_string($conn,$_REQUEST['CNI']);
            $phone = mysqli_real_escape_string($conn,$_REQUEST['phone']);

            $qr = mysqli_query($conn,"UPDATE users set
                prénom = '$prénom',nom='$nom',role='$role',email = '$email',CNI ='$cni',phone='$phone' where id='$id'");
                if ($qr) {
                    $_SESSION['message'][] = "2";
                    header("Location:/ENSAHify/views/coordinateur/teacher-management/view_teacher.php");
                } else {
                    $_SESSION['message'][] = "3";
                    header("Location: /ENSAHify/views/coordinateur/teacher-management/view_teacher.php");
                }
            }
        else{
        $prénom = mysqli_real_escape_string($conn,$_REQUEST['prénom']);
        $nom = mysqli_real_escape_string($conn,$_REQUEST['nom']);
        $genre = mysqli_real_escape_string($conn,$_REQUEST['genre']);
        $dateNaissance = mysqli_real_escape_string($conn,$_REQUEST['dateNaissance']);
        $dateNaissance = filter_var($dateNaissance, FILTER_SANITIZE_STRING);
        $sqlDateOfBirth = date('Y-m-d', strtotime(str_replace('-', '/', $dateNaissance)));
        $role = mysqli_real_escape_string($conn,$_REQUEST['role']);
        $email = mysqli_real_escape_string($conn,$_REQUEST['email']);
        $cni = mysqli_real_escape_string($conn,$_REQUEST['CNI']);
        $phone = mysqli_real_escape_string($conn,$_REQUEST['phone']);
        $dep = $_SESSION['dep_id'];

        $qr = mysqli_query($conn,"INSERT into users (
            prénom,nom,genre,dateNaissance,email,CNI,password,role,phone,id_dep,created_at) values (
            '".$prénom."','".$nom."','".$genre."','".$sqlDateOfBirth."','".$email."','".$cni."','".md5($cni)."',".$role.",'".$phone."','".$dep."','".date('Y-m-d H:i:s')."')");
            if ($qr) {
                $_SESSION['message'][] = "1";
                header("Location:/ENSAHify/views/coordinateur/teacher-management/add_teacher.php");
            } else {
                $_SESSION['message'][] = "0";
                header("Location: /ENSAHify/views/coordinateur/teacher-management/add_teacher.php");
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