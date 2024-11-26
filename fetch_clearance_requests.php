<?php
// Start the session
session_start();

// Include the database connection
include('../connect.php'); // Adjust this path according to your directory structure

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

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
    // Check if the 'department' key exists in the POST data
    if (isset($_POST['department'])) {
        // Sanitize the department input
        $department = mysqli_real_escape_string($conn, $_POST['department']);
        
        // Insert the request for the selected department
        $query = "INSERT INTO clearance_requests (student_id, department, status, requested_at) 
                  VALUES ('$student_id', '$department', 'pending', '$requested_at')";
    
        if (mysqli_query($conn, $query)) {
            echo "Clearance request submitted for $department!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // Handle the case where 'department' is not set
        echo "Department not selected!";
    }
}

// Query to fetch clearance requests for display
$query = "SELECT * FROM clearance_requests";
$result = mysqli_query($conn, $query);

// Check if there are results
if (mysqli_num_rows($result) > 0) {
    // Output data for each row
    while ($row = mysqli_fetch_assoc($result)) {
        $student_id = $row['student_id'];
        $department = $row['department'];
        $status = $row['status'];
        $requested_at = $row['requested_at'];

        // Adjusting the display logic for department
        if ($department == 'Request clearance from all departments') {
            $department_display = "Requested for all departments";
        } else {
            $department_display = $department; // For individual department requests
        }

        // Output the row
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$student_id}</td>
                <td>{$department_display}</td>
                <td>{$status}</td>
                <td>{$requested_at}</td>
                <td>
                    <button onclick='updateStatus({$row['id']}, \"Approved\")'>Approve</button>
                    <button onclick='updateStatus({$row['id']}, \"Rejected\")'>Reject</button>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='6'>No clearance requests found.</td></tr>";
}

// Close the database connection
mysqli_close($conn);
?>
