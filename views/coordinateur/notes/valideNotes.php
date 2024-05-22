<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_SESSION['user_data']['role'] == 2) {
        $data = array();
        $id_module = $_POST['module'];
        $qr = mysqli_query($conn, "SELECT n.*
                                   FROM notes n
                                   WHERE n.id_module = '$id_module'
                                   and n.valideProf = 1");
        while ($row = mysqli_fetch_assoc($qr)) {
            array_push($data, $row);
        }

        foreach ($data as $d) {
            $cne = $d['cne'];
            $update_query = "UPDATE notes SET valideCoord = 1 WHERE cne = '$cne' AND id_module = '$id_module'";
            mysqli_query($conn, $update_query);
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
