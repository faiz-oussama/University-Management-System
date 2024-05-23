<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');

if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 3) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['grades'])) {
            $id = $_SESSION['user_id'];
            $id_module = $_POST['module'];
            $CNE = $_POST['cne'];
            $is_sauvegarder = isset($_POST['sauvegarder']);
            $grades = $_POST['grades'];
            $valideProf = $_POST['valider'];
            foreach ($grades as $CNE => $grade) {
                if ($is_sauvegarder && $grade === '') {
                    // Skip saving this grade because it is empty
                    continue;
                }
                $grade = $grade !== '' ? floatval($grade) : null;
            
                $query = "INSERT INTO notes (id_teacher, cne, id_module, value, valideProf) VALUES ('$id', '$CNE', '$id_module', ";
                
                // Check if $grade is NULL or not
                if ($grade !== null) {
                    // If $grade is not NULL, include the grade value in the query
                    $query .= "'$grade', ";
                } else {
                    // If $grade is NULL, include NULL in the query
                    $query .= "NULL, ";
                }
                
                // Include valideProf value in the query
                $query .= "'$valideProf') ON DUPLICATE KEY UPDATE value = VALUES(value), valideProf = VALUES(valideProf)";
                
                mysqli_query($conn, $query);
            }
            header("Location: /ENSAHify/views/professeur/formNotes.php?id=$id_module"); // Redirect to avoid form resubmission on refresh
            exit();
}}
}
?>
