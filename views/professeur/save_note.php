<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');

if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 3 || $_SESSION['user_data']['role'] == 2 || $_SESSION['user_data']['role'] == 1) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['grades'])) {
            $id = $_SESSION['user_id'];
            $id_module = $_POST['module'];
            $is_sauvegarder = isset($_POST['sauvegarder']);
            $is_valider = isset($_POST['valider']);
            $grades = $_POST['grades'];

            foreach ($grades as $CNE => $grade) {
                if ($is_sauvegarder && $grade === '') {
                    // Skip saving this grade because it is empty
                    continue;
                }
                $grade = $grade !== '' ? floatval($grade) : 'NULL';
                $valideProf = $is_valider ? 1 : 0;

                $query = "INSERT INTO notes (id_teacher, cne, id_module, value, valideProf) 
                          VALUES ('$id', '$CNE', '$id_module', $grade, '$valideProf') 
                          ON DUPLICATE KEY UPDATE value = VALUES(value), valideProf = VALUES(valideProf)";
                
                mysqli_query($conn, $query) or die(mysqli_error($conn));
            }
            header("Location: /ENSAHify/views/professeur/formNotes.php?id=$id_module");
            exit();
        }
    }
}
?>
