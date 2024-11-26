<?php
session_start();
include('../connect.php');

if (empty($_SESSION['admin-username'])) {
    header("Location: login.php");
    exit;
}

// Fetch cleared students
$sql_cleared = "SELECT fullname, matric_no FROM students WHERE 
                is_assistant_registrar_exam_approved = 1 AND 
                is_assistant_registrar_stud_affairs_approved = 1 AND 
                is_director_head_approved = 1 AND 
                is_librarian_approved = 1 AND 
                is_bursar_approved = 1 AND 
                is_deputy_registrar_stud_affairs_approved = 1";
$result_cleared = $conn->query($sql_cleared);

// Fetch uncleared students
$sql_uncleared = "SELECT fullname, matric_no FROM students WHERE 
                  is_assistant_registrar_exam_approved = 0 OR 
                  is_assistant_registrar_stud_affairs_approved = 0 OR 
                  is_director_head_approved = 0 OR 
                  is_librarian_approved = 0 OR 
                  is_bursar_approved = 0 OR 
                  is_deputy_registrar_stud_affairs_approved = 0";
$result_uncleared = $conn->query($sql_uncleared);

// Prepare CSV output
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="student_clearance_report.csv"');
$output = fopen('php://output', 'w');

// Write headers
fputcsv($output, ['Status', 'Full Name', 'Matric No']);

// Write cleared students
while ($row = $result_cleared->fetch_assoc()) {
    fputcsv($output, ['Cleared', $row['fullname'], $row['matric_no']]);
}

// Write uncleared students
while ($row = $result_uncleared->fetch_assoc()) {
    fputcsv($output, ['Uncleared', $row['fullname'], $row['matric_no']]);
}

fclose($output);
exit;
