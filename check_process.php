<?php 
session_start();
error_reporting(0);
include('connect.php');

// Redirect to login if the session is empty
if (empty($_SESSION['matric_no'])) {   
    header("Location: login.php"); 
    exit;
}

// Get student ID from session
$ID = $_SESSION["ID"];

// Fetch comments for the student along with the admin's name
$sql_comments = "SELECT c.comment, c.date_added, a.fullname AS admin_name 
                 FROM clearance_comments c
                 JOIN admin a ON c.admin_id = a.ID
                 WHERE c.student_id='$ID' 
                 ORDER BY c.date_added DESC";

$result_comments = $conn->query($sql_comments);

$comments = [];
if ($result_comments) {
    while ($row = $result_comments->fetch_assoc()) {
        $comments[] = [
            'comment' => $row['comment'],
            'date_added' => $row['date_added'],
            'admin_name' => $row['admin_name'] // Get the admin's name
        ];
    }
}

// Determine the status message
$status_message = 'Pending';
if (count($comments) > 0) {
    $status_message .= ': ' . implode(', ', array_column($comments, 'comment'));
} else {
    $status_message .= ': No specific reason provided.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Process | Clearance Comments</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Clearance Comments</h1>
        <p><?php echo $status_message; ?></p>
        <h3>Comments:</h3>
        <ul>
            <?php foreach ($comments as $comment): ?>
                <li>
                    <?php echo htmlspecialchars($comment['comment']); ?> 
                    <small>(<?php echo $comment['date_added']; ?>)</small> 
                    <br>
                    <small>By: <?php echo htmlspecialchars($comment['admin_name']); ?></small> <!-- Display admin name -->
                </li>
            <?php endforeach; ?>
        </ul>
        <a href="index.php" class="btn btn-primary">Back to Dashboard</a>
    </div>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
