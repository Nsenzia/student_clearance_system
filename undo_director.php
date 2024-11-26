<?php
session_start();
error_reporting(0);
include('../connect.php');
if(strlen($_SESSION['admin-username'])=="")
{   
    header("Location: login.php"); 
}
else {

    $username = $_SESSION['admin-username'];
    date_default_timezone_set('Africa/Zambia');
    $current_date = date('Y-m-d H:i:s');

    // undo student clearance
    if(isset($_GET['id'])) {
        $id = intval($_GET['id']);

        // Update the student's clearance status to 'not cleared'
        mysqli_query($conn, "UPDATE students SET is_director_head_approved='0' WHERE ID='$id'");

        // Redirect back to the student clearance page after undoing clearance
        header("Location: student-clearance.php");
    }
}
?>
