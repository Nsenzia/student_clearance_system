<?php
// Start the session
session_start();

// Include the database connection
include('connect.php');

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    echo "You must be logged in to request clearance.";
    exit;
}

// Get the student ID from session
$student_id = $_SESSION['student_id'];
$requested_at = date('Y-m-d H:i:s');

// Check if the student selected to request clearance from all departments
if (isset($_POST['all_departments']) && $_POST['all_departments'] == 'yes') {
    // Insert a single clearance request for all departments
    $query = "INSERT INTO clearance_requests (student_id, department, status, requested_at) 
              VALUES ('$student_id', 'Request clearance from all departments', 'pending', '$requested_at')";
    
    if (mysqli_query($conn, $query)) {
        echo "Clearance request for all departments submitted successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Request for a single department (assuming there's a field in the form for selecting a single department)
    $department = $_POST['department'];

    // Sanitize the department input
    $department = mysqli_real_escape_string($conn, $department);

    // Insert the request for the selected department
    $query = "INSERT INTO clearance_requests (student_id, department, status, requested_at) 
              VALUES ('$student_id', '$department', 'pending', '$requested_at')";

    if (mysqli_query($conn, $query)) {
        echo "Clearance request submitted for $department!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
