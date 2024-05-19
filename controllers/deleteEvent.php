<?php
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $eventId = $_POST['id'];

    $query = "DELETE FROM timetable_events WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $eventId);

    if ($stmt->execute()) {
        echo "Event deleted successfully";
    } else {
        echo "Error deleting event";
    }

    $stmt->close();
    $conn->close();
}
?>
