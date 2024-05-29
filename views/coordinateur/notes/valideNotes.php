<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/controllers/email_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_SESSION['user_data']['role'] == 2) {
        $data = array();
        $user_id = $_SESSION['user_id'];
        $id_module = $_POST['module'];
        $qr = mysqli_query($conn, "SELECT n.*,u.email,m.name
                                   FROM notes n
                                   JOIN users u ON n.cne = u.CNE
                                   JOIN module m ON n.id_module = m.id
                                   WHERE n.id_module = '$id_module'
                                   and n.valideProf = 1");
        while ($row = mysqli_fetch_assoc($qr)) {
            array_push($data, $row);
        }

        foreach ($data as $d) {
            $cne = $d['cne'];
            $email = $d['email'];
            $module = $d['name'];
            $sender = $_SESSION['role_name'];
            $update_query = "UPDATE notes SET valideCoord = 1 WHERE cne = '$cne' AND id_module = '$id_module'";
            mysqli_query($conn, $update_query);
            $subject = "New Grade Notification";
            $body = "Dear Student,<br><br>Your grade for module $module has been released. Please check your student portal for more details.<br><br>Best regards,<br>ENSAH";

            
            sendEmail($email, $subject, $body);
        }
        

        $_SESSION['message'] = "1";
    } else {
        $_SESSION['message'][] = "0";
    }

    // Redirect back to the previous page or to a success page
    
    header("Location: /ENSAHify/views/coordinateur/notes/formNotes.php?id=$id_module");
    
    exit;
} else {
    header("Location: /ENSAHify/index.php?error=UnAuthorized Access");
    exit;
}
?>
