<?php
session_start();
include('../../Database.php');

if(isset($_REQUEST['email']) && !empty($_REQUEST['email']) && isset($_REQUEST['password']) && !empty($_REQUEST['password'])){
    $email = mysqli_real_escape_string($conn,$_REQUEST['email']);
    $password = mysqli_real_escape_string($conn,$_REQUEST['password']);
    $qr = mysqli_query($conn,"select * from users where email ='".$email."'and password='".md5($password)."'");

    if(mysqli_num_rows($qr)>0){
        $data = mysqli_fetch_assoc($qr);
        $role_id = $data['role'];
        $dep_id = $data['id_dep'];
        $fil_nom = $data['nom_filiere'];
        $user_id = $data['id'];
        $niveau = $data['niveau'];
        $cne = $data['CNE'];
        $role_query = mysqli_query($conn, "SELECT role FROM roles WHERE id = '$role_id'");
        $role_data = mysqli_fetch_assoc($role_query);
        $data['role_name'] = $role_data['role'];
        $_SESSION['user_data'] = $data;
        $_SESSION['dep_id'] = $dep_id;
        $_SESSION['fil_nom'] = $fil_nom;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['niveau'] = $niveau;
        $_SESSION['cne'] = $cne;
        $_SESSION['role_name'] =  $data['role_name'];
        if($data['role'] == 2)
        {
            header("Location:../../views/coordinateur/home.php");
            exit();
        }
        else if($data['role'] == 3)
        {
            header("Location:../../views/professeur/home.php");
            exit();
        }
        else if($data['role'] == 4)
        {
            header("Location:../../views/student/home.php");
            exit();
        }
        
    }
    else{
        $_SESSION['error'][] = "Invalid login details";
        header("Location:../../index.php");
        exit();
    }
}
else{
    $_SESSION['error'][] = "Please enter your login credentials";
    header("Location:../../index.php");
    exit();
}
?>
