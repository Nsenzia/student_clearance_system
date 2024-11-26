<?php
include('../connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Prepare and bind
    $stmt = $conn->prepare("UPDATE clearance_requests SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        echo "Status updated successfully.";
    } else {
        echo "Error updating status: " . $conn->error;
    }

    $stmt->close();
}
?>
