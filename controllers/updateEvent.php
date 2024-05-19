<?php 
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');

if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 2) {
        $id = $_POST['id'];
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $start = mysqli_real_escape_string($conn, $_POST['start']);
        $end = mysqli_real_escape_string($conn, $_POST['end']);

        
        $startDateTime = new DateTime($start);
        $endDateTime = new DateTime($end);

        $date = $startDateTime->format('Y-m-d');
        $startTime = $startDateTime->format('H:i:s');
        $endTime = $endDateTime->format('H:i:s');

        
        $update_query = "UPDATE timetable_events SET date='$date', start_time='$startTime', end_time='$endTime', subject='$title' WHERE id='$id'";

        if (mysqli_query($conn, $update_query)) {
            $_SESSION['message'] = "Event updated successfully";
        } else {
            $_SESSION['message'] = "Failed to update event: " . mysqli_error($conn);
        }
        header("Location: /ENSAHify/views/coordinateur/timetable/timetable.php");
        exit();
    } else {
        header("Location: /ENSAHify/error.php");
    }
} else {
    header("Location: /ENSAHify/index.php?error=UnAuthorized Access");
    exit();
}
?>
