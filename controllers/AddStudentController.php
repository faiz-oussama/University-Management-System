<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');
if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 2) {
        if(isset($_GET['id'])){
            $id = $_POST['id'];
            $prénom = mysqli_real_escape_string($conn,$_REQUEST['prénom']);
            $nom = mysqli_real_escape_string($conn,$_REQUEST['nom']);
            $genre = mysqli_real_escape_string($conn,$_REQUEST['genre']);
            $dateNaissance = mysqli_real_escape_string($conn,$_REQUEST['dateNaissance']);
            $dateNaissance = filter_var($dateOfBirth, FILTER_SANITIZE_STRING);
            $sqlDateOfBirth = date('Y-m-d', strtotime(str_replace('-', '/', $dateOfBirth)));
            $role = mysqli_real_escape_string($conn,$_REQUEST['role']);
            $email = mysqli_real_escape_string($conn,$_REQUEST['email']);
            $niveau = mysqli_real_escape_string($conn,$_REQUEST['niveau']);
            $cne = mysqli_real_escape_string($conn,$_REQUEST['CNE']);
            $cni = mysqli_real_escape_string($conn,$_REQUEST['CNI']);
            $phone = mysqli_real_escape_string($conn,$_REQUEST['phone']);

            $qr = mysqli_query($conn,"UPDATE users set
                prénom = '$prénom',nom='$nom',genre = '$genre',role='$role',email = '$email',niveau= '$niveau',CNE ='$cne',CNI ='$cni',phone='$phone' where id='$id'");
                if ($qr) {
                    $_SESSION['message'][] = "2";
                    header("Location:/ENSAHify/views/coordinateur/student-management/view_student.php");
                } else {
                    $_SESSION['message'][] = "3";
                    header("Location: /ENSAHify/views/coordinateur/student-management/view_student.php");
                }
            }
        else{
        $prénom = mysqli_real_escape_string($conn,$_REQUEST['prénom']);
        $nom = mysqli_real_escape_string($conn,$_REQUEST['nom']);
        $genre = mysqli_real_escape_string($conn,$_REQUEST['genre']);
        $dateNaissance = mysqli_real_escape_string($conn,$_REQUEST['dateNaissance']);
        $dateNaissance = filter_var($dateOfBirth, FILTER_SANITIZE_STRING);
        $sqlDateOfBirth = date('Y-m-d', strtotime(str_replace('-', '/', $dateOfBirth)));
        $role = mysqli_real_escape_string($conn,$_REQUEST['role']);
        $email = mysqli_real_escape_string($conn,$_REQUEST['email']);
        $niveau = mysqli_real_escape_string($conn,$_REQUEST['niveau']);
        $cne = mysqli_real_escape_string($conn,$_REQUEST['CNE']);
        $cni = mysqli_real_escape_string($conn,$_REQUEST['CNI']);
        $phone = mysqli_real_escape_string($conn,$_REQUEST['phone']);

        $qr = mysqli_query($conn,"INSERT into users (
            prénom,nom,genre,dateNaissance,email,niveau,CNE,CNI,password,role,phone,created_at) values (
            '".$prénom."','".$nom."','".$genre."','".$sqlDateOfBirth."','".$email."','".$niveau."','".$cne."','".$cni."','".md5($cne)."',".$role.",'".$phone."','".date('Y-m-d H:i:s')."')");
            if ($qr) {
                $_SESSION['message'][] = "1";
                header("Location:/ENSAHify/views/coordinateur/student-management/add_student.php");
            } else {
                $_SESSION['message'][] = "0";
                header("Location: /ENSAHify/views/coordinateur/student-management/add_student.php");
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