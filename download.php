<?php
// Start the session
session_start();

// Check if the user is logged in
if (empty($_SESSION['matric_no'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

// Path to the document
$file = 'documents/student_clearance_form.docx'; // Change this to the correct file path

// Check if the file exists
if (file_exists($file)) {
    // Set headers to initiate a download
    header('Content-Description: File Transfer');
    header('Content-Type: application/docx'); // Set the content type
    header('Content-Disposition: attachment; filename="' . basename($file) . '"'); // Suggest a filename
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file)); // Set the content length
    flush(); // Flush system output buffer
    readfile($file); // Read the file and send it to the user
    exit;
} else {
    echo "File not found."; // Show an error message if the file doesn't exist
}

