<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');
if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 2) {
    
    $fil_nom = $_SESSION['fil_nom'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $moduleQuery = "SELECT id FROM module WHERE name = '$name'";
    $moduleResult = mysqli_query($conn, $moduleQuery);

    if ($moduleResult && mysqli_num_rows($moduleResult) > 0) {
        $moduleRow = mysqli_fetch_assoc($moduleResult);
        $moduleId = $moduleRow['id'];
    }

    // Step 2: Retrieve the teacher ID from the affectationmoduleprof table using the module ID
    $affectationQuery = "SELECT id_teacher FROM affectationmoduleprof WHERE id_module = '$moduleId'";
    $affectationResult = mysqli_query($conn, $affectationQuery);

    if ($affectationResult && mysqli_num_rows($affectationResult) > 0) {
        $affectationRow = mysqli_fetch_assoc($affectationResult);
        $teacherId = $affectationRow['id_teacher'];

        // Step 3: Retrieve the teacher's name from the users table using the teacher ID
        $teacherQuery = "SELECT prénom, nom FROM users WHERE id = '$teacherId'";
        $teacherResult = mysqli_query($conn, $teacherQuery);

        if ($teacherResult && mysqli_num_rows($teacherResult) > 0) {
            $teacherRow = mysqli_fetch_assoc($teacherResult);
            $teacherName = $teacherRow['prénom'] . ' ' . $teacherRow['nom'];
        }
    }
    
    $semestre = mysqli_real_escape_string($conn, $_POST['semestre']);
    $level = mysqli_real_escape_string($conn, $_POST['level']); 
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $start_time = mysqli_real_escape_string($conn, $_POST['startTime']);
    $end_time = mysqli_real_escape_string($conn, $_POST['endTime']);
    $dateObj = DateTime::createFromFormat('d-m-Y', $date);
    $formatted_date = $dateObj->format('Y-m-d');
    $query = "INSERT INTO timetable_events (teacher_id, section, level, subject,semestre,date ,start_time, end_time) 
              VALUES ('$teacherId', '$fil_nom', '$level','$name','$semestre' ,'$formatted_date', '$start_time', '$end_time')";

    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Event added succesasfully";
    } else {
        $_SESSION['message'] = "Failed to add event";
    }
    header("Location: /ENSAHify/views/coordinateur/timetable/timetable.php?level=" . $level ."&semestre=" . $semestre);
    exit();
?>
<?php }
    else {
        header("Location: /ENSAHify/error.php");
    }
}else {
    header("Location: index.php?error=UnAuthorized Access");
}

?>